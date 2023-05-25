#ifdef ESP32
  #include <WiFi.h>
  #include <HTTPClient.h>
#else
  #include <ESP8266WiFi.h>
  #include <ESP8266HTTPClient.h>
  #include <WiFiClient.h>
#endif

#include <TinyGPS++.h>
#include <SoftwareSerial.h>

TinyGPSPlus gps;
 
// Replace with your Wi-Fi credentials
const char* ssid = "Galaxy";
const char* password = "123123123";

// Replace with your server's IP address and port number
String URL = "http://192.168.43.22/receive_data.php";

// Replace with your unique identifier for this vehicle
const char* v = "KL95D9123";
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
    Serial.print(".");
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
    String postData = "ve=" + String(v) + "&lat=" + String(LatitudeString) + "&lon=" + String(LongitudeString); // Change this to the data you want to send
    HTTPClient http;
    WiFiClient client;
    http.begin(client, URL);
    http.addHeader("Content-Type", "application/x-www-form-urlencoded");
    int httpCode = http.POST(postData);
    String payload = http.getString();
    Serial.print("URL : "); Serial.println(URL); 
    Serial.print("Data: "); Serial.println(postData);
    Serial.print("httpCode: "); Serial.println(httpCode);
    Serial.print("payload : "); Serial.println(payload);
    Serial.println("--------------------------------------------------");
    delay(5000);
  }
  // else{
  //   String postData = "ve=" + String(v) + "&lat=" + "9.93589" + "&lon=" + "76.2718"; // Change this to the data you want to send
  //   HTTPClient http;
  //   WiFiClient client;
  //   http.begin(client, URL);
  //   http.addHeader("Content-Type", "application/x-www-form-urlencoded");
  //   int httpCode = http.POST(postData);
  //   String payload = http.getString();
  //   Serial.print("URL : "); Serial.println(URL); 
  //   Serial.print("Data: "); Serial.println(postData);
  //   Serial.print("httpCode: "); Serial.println(httpCode);
  //   Serial.print("payload : "); Serial.println(payload);
  //   Serial.println("--------------------------------------------------");
  //   delay(5000);
  // }
}
