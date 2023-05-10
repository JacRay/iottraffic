#include <ESP8266WiFi.h>
#include <ESP8266HTTPClient.h>
#include <SoftwareSerial.h>

// Replace with your Wi-Fi credentials
const char* ssid = "your_SSID";
const char* password = "your_PASSWORD";

// Replace with your server's IP address and port number
const char* server = "your_SERVER_IP_ADDRESS";
const int port = 80;

// Replace with your unique identifier for this vehicle
const char* vehicle_id = "your_VEHICLE_ID";

// GPS module serial interface configuration
SoftwareSerial gpsSerial(D5, D6);

void setup() {
  // Start serial communication
  Serial.begin(9600);

  // Configure GPS module serial interface
  gpsSerial.begin(9600);

  // Connect to Wi-Fi
  WiFi.begin(ssid, password);
  while (WiFi.status() != WL_CONNECTED) {
    delay(1000);
    Serial.println("Connecting to WiFi...");
  }

  Serial.println("Connected to Wi-Fi.");
}

void loop() {
  // Read GPS data
  String gpsData = "";
  while (gpsSerial.available()) {
    gpsData += char(gpsSerial.read());
  }

  // Send GPS data to server
  if (gpsData != "") {
    String data = "vehicle_id=" + String(vehicle_id) + "&gps_data=" + gpsData;
    HTTPClient http;
    http.begin(server, port, "/receive_data.php");
    http.addHeader("Content-Type", "application/x-www-form-urlencoded");
    int httpCode = http.POST(data);
    if (httpCode == HTTP_CODE_OK) {
      String response = http.getString();
      Serial.println(response);
    }
    http.end();
  }

  delay(1000);
}
