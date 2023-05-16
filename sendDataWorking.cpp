#ifdef ESP32
  #include <WiFi.h>
  #include <HTTPClient.h>
#else
  #include <ESP8266WiFi.h>
  #include <ESP8266HTTPClient.h>
  #include <WiFiClient.h>
#endif
const char* ssid = "Galaxy";
const char* password = "123123123";

String URL = "http://192.168.43.22/receive_data.php";
int v = 123;
float lat = 6.4;
float lon = 5.1;
void setup() {
  Serial.begin(115200);

  // Connect to Wi-Fi
  WiFi.begin(ssid, password);
  while (WiFi.status() != WL_CONNECTED) {
    delay(1000);
    Serial.println("Connecting to Wi-Fi...");
  }
  Serial.println("Connected to Wi-Fi");

  // Wait for serial to connect
  while (!Serial) {
    delay(50);
  }
}

void loop() {
  String postData = "ve=" + String(v) + "&lat=" + String(lat) + "&lon=" + String(lon); // Change this to the data you want to send

  // Send POST request
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
