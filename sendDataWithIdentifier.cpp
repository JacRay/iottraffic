#include <ESP8266WiFi.h>
#include <WiFiClient.h>
#include <ESP8266HTTPClient.h>
#include <SoftwareSerial.h>
#include <TinyGPS++.h>

// Define the WiFi credentials
const char* wifiSSID = "keralavison";
const char* wifiPassword = "12345678";

// Define the GPS module identifier
const char* gpsIdentifier = "GPS1";

// Define the server URL
const char* serverURL = "http://www.iottraffic.xyz/getDataWithidentifier.php";

// Define the GPS module serial port
SoftwareSerial gpsSerial(5, 4); // RX, TX

// Initialize the GPS parser
TinyGPSPlus gps;

void setup() {
  // Initialize the serial port
  Serial.begin(9600);

  // Initialize the GPS serial port
  gpsSerial.begin(9600);

  // Connect to the WiFi network
  WiFi.begin(wifiSSID, wifiPassword);
  while (WiFi.status() != WL_CONNECTED) {
    delay(1000);
  }
}

void loop() {
  // Parse the GPS data
  while (gpsSerial.available() > 0) {
    if (gps.encode(gpsSerial.read())) {
      // Check if a GPS fix was obtained
      if (gps.location.isValid()) {
        // Build the HTTP POST request payload
        String payload = "identifier=";
        payload += gpsIdentifier;
        payload += "&latitude=";
        payload += gps.location.lat();
        payload += "&longitude=";
        payload += gps.location.lng();

        // Send the HTTP POST request to the server
        HTTPClient http;
        http.begin(serverURL);
        http.addHeader("Content-Type", "application/x-www-form-urlencoded");
        int httpCode = http.POST(payload);
        http.end();

        // Check if the request was successful
        if (httpCode == HTTP_CODE_OK) {
          Serial.println("Location sent successfully");
        } else {
          Serial.print("Failed to send location data: ");
          Serial.println(httpCode);
        }
      } else {
        Serial.println("GPS fix not obtained");
      }
    }
  }
}
