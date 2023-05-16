#include <ESP8266WiFi.h>
#include <TinyGPS++.h>
#include <ESP8266HTTPClient.h>
#include <SoftwareSerial.h>

TinyGPSPlus gps;
 
// Replace with your Wi-Fi credentials
const char* ssid = "Galaxy";
const char* password = "123123123";

// Replace with your server's IP address and port number
const char* host = "iottraffic.rf.gd";

// Replace with your unique identifier for this vehicle
const char* vehicle_id = "KL1234";
float Latitude , Longitude;
String LatitudeString , LongitudeString;

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
  while (gpsSerial.available() > 0) {
    if (gps.encode(gpsSerial.read()))
    {
      if (gps.location.isValid())
      {
        Latitude = gps.location.lat();
        LatitudeString = String(Latitude , 6);
        Longitude = gps.location.lng();
        LongitudeString = String(Longitude , 6);
        Serial.println(LatitudeString);
      }
    }
  }

  // Send GPS data to server
  if (gps.location.isValid()) {
    Serial.print("Connecting to :");
    Serial.println(host);
    WiFiClientSecure client;
    const int httpPort = 80;
    client.setInsecure();
    if(!client.connect(host, httpPort)){
      Serial.println("Connection failed");
      return;
    }
    String url = "/receive_data.php?vehicle_id=" + String(vehicle_id) + "&lat=" + String(LatitudeString) + "&lon=" + String(LongitudeString);
    Serial.println(url);
    client.print(String("GET ") + url + " HTTP/1.1\r\n" + "Host: " + host + "\r\n" + "Connection: close\r\n\r\n");
    Serial.println("Closing Connection");
  }
  else{
    Serial.print("Connecting to :");
    Serial.println(host);
    WiFiClientSecure client;
    const int httpPort = 80;
    client.setInsecure();
    if(!client.connect(host, httpPort)){
      Serial.println("Connection failed");
      return;
    }
    String url = "/receive_data.php?vehicle_id=" + String(vehicle_id) + "&lat=6.7" + "&lon=7";
    Serial.println(url);
    client.print(String("GET ") + url + " HTTP/1.1\r\n" + "Host: " + host + "\r\n" + "Connection: close\r\n\r\n");
    Serial.println("Closing Connection");
  }

  delay(100);
}
