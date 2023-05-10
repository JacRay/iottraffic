#include <ESP8266WiFi.h>

// Replace with the SSID and password of your WiFi network
const char* ssid = "your_SSID";
const char* password = "your_PASSWORD";

// Replace with the IP address of your server and the port it is listening on
const char* server_ip = "192.168.1.100";
const int server_port = 12345;

void setup() {
  // Connect to WiFi network
  WiFi.begin(ssid, password);
  while (WiFi.status() != WL_CONNECTED) {
    delay(1000);
    Serial.println("Connecting to WiFi...");
  }
  Serial.println("Connected to WiFi.");

  // Establish TCP connection to server
  WiFiClient client;
  if (!client.connect(server_ip, server_port)) {
    Serial.println("Connection failed.");
    return;
  }
  Serial.println("Connected to server.");

  // Receive command from server
  while (client.connected()) {
    if (client.available()) {
      String command = client.readStringUntil('\n');
      Serial.println("Received command: " + command);
      
      // Switch on traffic light based on command
      if (command == "green") {
        // Switch on green light
        Serial.println("Switching on green light.");
        // Insert code here to switch on the green light
      } else if (command == "red") {
        // Switch on red light
        Serial.println("Switching on red light.");
        // Insert code here to switch on the red light
      } else if (command == "yellow") {
        // Switch on yellow light
        Serial.println("Switching on yellow light.");
        // Insert code here to switch on the yellow light
      }
    }
  }

  // Close TCP connection
  client.stop();
  Serial.println("Disconnected from server.");
}

void loop() {
  // Nothing to do in loop()
}
