#ifdef ESP32
  #include <WiFi.h>
  #include <HTTPClient.h>
#else
  #include <ESP8266WiFi.h>
  #include <ESP8266HTTPClient.h>
  #include <WiFiClient.h>
#endif


// Replace with your Wi-Fi credentials
const char* ssid = "Galaxy";
const char* password = "123123123";

// Replace with your server's IP address and port number
String URL = "http://192.168.43.22/output.txt";
// D0 - RedNorth D1 - GreenNorth
// D2 - RedWest D3 - GreenWest
// D4 - RedSouth D5 - GreenSouth
// D6 - RedEast D7 - GreenEast
#define R_NORTH D0
#define G_NORTH D1
#define R_WEST D2
#define G_WEST D3
#define R_SOUTH D4
#define G_SOUTH D5
#define R_EAST D6
#define G_EAST D7

void setup() {
  pinMode(R_NORTH, OUTPUT);
  pinMode(G_NORTH, OUTPUT);
  pinMode(R_WEST, OUTPUT);
  pinMode(G_WEST, OUTPUT);
  pinMode(R_SOUTH, OUTPUT);
  pinMode(G_SOUTH, OUTPUT);
  pinMode(R_EAST, OUTPUT);
  pinMode(G_EAST, OUTPUT);
  Serial.begin(9600);
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
    digitalWrite(R_NORTH, HIGH);
    digitalWrite(R_WEST, HIGH);
    digitalWrite(R_SOUTH, HIGH);
    digitalWrite(R_EAST, HIGH);
    Serial.println("10 10 10 10");
    //seconds
    int looptime = 40;
    HTTPClient http;
    WiFiClient client;
    http.begin(client, URL);
    int httpCode = http.GET();
    if (httpCode == HTTP_CODE_OK) {
        String payload = http.getString();

        // Parse the payload and assign values to variables
        int values[4];
        int count = 0;
        char* token = strtok((char*)payload.c_str(), " ");
        while (token != NULL && count < 4) {
            values[count] = atoi(token);
            token = strtok(NULL, " ");
            count++;
        }

        if (count == 4) {
            int sum = values[0]+values[1]+values[2]+values[3];
            int north = (looptime/sum)*values[0]*1000;
            int west = (looptime/sum)*values[1]*1000;
            int south = (looptime/sum)*values[2]*1000;
            int east = (looptime/sum)*values[3]*1000;
            // Use the values as needed
            Serial.print("Received values: ");
            Serial.print("North: ");
            Serial.print(north);
            Serial.print(", West: ");
            Serial.print(west);
            Serial.print(", South: ");
            Serial.print(south);
            Serial.print(", East: ");
            Serial.println(east);
            int i = 0;
            digitalWrite(R_NORTH, LOW);
            digitalWrite(G_NORTH, HIGH);
            Serial.println("01 10 10 10");
            delay(north);
            digitalWrite(G_NORTH, LOW);
            digitalWrite(R_NORTH, HIGH);
            digitalWrite(R_WEST, LOW);
            digitalWrite(G_WEST, HIGH);
            Serial.println("10 01 10 10");
            delay(west);
            digitalWrite(G_WEST, LOW);
            digitalWrite(R_WEST, HIGH);
            digitalWrite(R_SOUTH, LOW);
            digitalWrite(G_SOUTH, HIGH);
            Serial.println("10 10 01 10");
            delay(south);
            digitalWrite(G_SOUTH, LOW);
            digitalWrite(R_SOUTH, HIGH);
            digitalWrite(R_EAST, LOW);
            digitalWrite(G_EAST, HIGH);
            Serial.println("10 10 10 01");
            delay(east);
        } else {
            Serial.println("Invalid response");
        }
    } else {
        Serial.print("Error accessing URL. HTTP code: ");
        Serial.println(httpCode);
    }

    http.end();
}
