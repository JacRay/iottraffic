#include <SoftwareSerial.h>
#include <ESP8266WiFi.h>
#include <WiFiClient.h>

// Define the Wi-Fi credentials
const char* ssid = "YOUR_WIFI_SSID";
const char* password = "YOUR_WIFI_PASSWORD";

// Define the server address and port
const char* serverAddress = "http://YOUR_SERVER_ADDRESS/location.php";
const int serverPort = 80;

// Define the software serial pins
const int gpsRxPin = 4;
const int gpsTxPin = 5;

// Define the software serial object
SoftwareSerial gpsSerial(gpsRxPin, gpsTxPin);

void setup() {
  // Initialize the serial port for debugging
  Serial.begin(9600);
  
  // Initialize the GPS module
  gpsSerial.begin(9600);
  
  // Connect to the Wi-Fi network
  Serial.print("Connecting to ");
  Serial.println(ssid);
  WiFi.begin(ssid, password);
  while (WiFi.status() != WL_CONNECTED) {
    delay(1000);
    Serial.print(".");
  }
  Serial.println("");
  Serial.println("WiFi connected");  
}

void loop() {
  // Wait for a GPS fix
  while (!gpsSerial.available()) {
    delay(1000);
  }
  
  // Read the GPS data
  String gpsData = gpsSerial.readStringUntil('\n');
  Serial.println(gpsData);
  
  // Extract the latitude and longitude from the GPS data
  String latitude = "";
  String longitude = "";
  if (gpsData.startsWith("$GPGGA")) {
    int index1 = gpsData.indexOf(',');
    int index2 = gpsData.indexOf(',', index1 + 1);
    int index3 = gpsData.indexOf(',', index2 + 1);
    int index4 = gpsData.indexOf(',', index3 + 1);
    int index5 = gpsData.indexOf(',', index4 + 1);
    int index6 = gpsData.indexOf(',', index5 + 1);
    latitude = gpsData.substring(index3 + 1, index4);
    longitude = gpsData.substring(index5 + 1, index6);
  }
  
  // Send the latitude and longitude to the server
  if (latitude != "" && longitude != "") {
    WiFiClient client;
    if (client.connect(serverAddress, serverPort)) {
      String postData = "latitude=" + latitude + "&longitude=" + longitude;
      client.println("POST /location.php HTTP/1.1");
      client.println("Host: YOUR_SERVER_ADDRESS");
      client.println("Content-Type: application/x-www-form-urlencoded");
      client.print("Content-Length: ");
      client.println(postData.length());
      client.println();
      client.println(postData);
      delay(100);
      while (client.available()) {
        Serial.write(client.read());
      }
      client.stop();
    } else {
      Serial.println("Connection failed");
    }
  }
  
  // Wait for 10 seconds before reading the next GPS data
  delay(10000);
}
