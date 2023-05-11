#include <ESP8266WiFi.h>
#include <WiFiClient.h>
#include <ESP8266HTTPClient.h>
#include <TinyGPS++.h>

// Replace with your network credentials
const char* ssid = "Galaxy";
const char* password = "123123123";

// Server details
const char* serverName = "http://your_server_address/receive_data.php";
HTTPClient http;
WiFiClient client;

// GPS details
TinyGPSPlus gps;
HardwareSerial serialGPS(2); // change the number if using other pins

void setup() {
  // Start serial communication
  Serial.begin(9600);
  serialGPS.begin(9600, SERIAL_8N1, 16, 17); // change the pins if using other pins

  // Connect to Wi-Fi
  WiFi.begin(ssid, password);
  while (WiFi.status() != WL_CONNECTED) {
    delay(1000);
    Serial.println("Connecting to WiFi...");
  }
  Serial.println("Connected to WiFi");

}

void loop() {
  // Check if GPS has data
  while (serialGPS.available() > 0) {
    if (gps.encode(serialGPS.read())) {
      // Get the latitude and longitude
      String lat = String(gps.location.lat(), 6);
      String lon = String(gps.location.lng(), 6);
      
      // Send the data to the server
      String serverPath = serverName + "?lat=" + lat + "&lon=" + lon;
      http.begin(client, serverPath);
      int httpResponseCode = http.GET();
      if (httpResponseCode>0) {
        Serial.print("HTTP Response code: ");
        Serial.println(httpResponseCode);
      }
      else {
        Serial.print("Error code: ");
        Serial.println(httpResponseCode);
      }
      http.end();
    }
  }
}
