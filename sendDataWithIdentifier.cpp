#include <ESP8266WiFi.h>
#include <TinyGPS++.h>
#include <ESP8266HTTPClient.h>
#include <SoftwareSerial.h>

TinyGPSPlus gps;
 
// Replace with your Wi-Fi credentials
const char* ssid = "Galaxy";
const char* password = "123123123";

// Replace with your server's IP address and port number
const char* server = "192.168.43.155";
const int port = 80;

// Replace with your unique identifier for this vehicle
const char* vehicle_id = "KL1234";

// GPS module serial interface configuration
SoftwareSerial gpsSerial(4, 5);
void setup() {
  Serial.begin(9600);
  gpsSerial.begin(9600);
  Serial.println();
  Serial.print("Connecting");
  WiFi.begin(ssid, password);
  while (WiFi.status() != WL_CONNECTED) 
  {
    delay(500);
    Serial.println(".");
  }
  Serial.println("");
  Serial.println("WiFi connected");
}

void loop() {
  // Read GPS data
  String gpsData = "";
  while (gpsSerial.available() > 0) {
    gpsData += char(gpsSerial.read());
    Serial.println("GPS data available");
  }

  // Send GPS data to server
  if (gpsData != "") {
    Serial.println("Connect");
    String data = "vehicle_id=" + String(vehicle_id) + "&gps_data=" + gpsData;
    HTTPClient http;
    WiFiClient client;
    http.begin(client, server, port, "/receive_data.php");
    http.addHeader("Content-Type", "application/x-www-form-urlencoded");
    int httpCode = http.POST(data);
    if (httpCode == HTTP_CODE_OK) {
      Serial.println("Data send");
      String response = http.getString();
      Serial.println(response);
    }
    http.end();
  }

  delay(1000);
}
