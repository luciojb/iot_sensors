#include <DHT.h>
#include <SPI.h>
#include <UIPEthernet.h>
 
#define DHTPIN 7 // pino que estamos conectando
#define DHTTYPE DHT22 // DHT 22

DHT dht(DHTPIN, DHTTYPE);

String id = "s0001";

byte mac[] = {0x74, 0x69, 0x69, 0x2D, 0x30, 0x35};

//Setando IP
IPAddress ip(192, 168, 100, 146);
IPAddress gateway(192, 168, 100, 254);
IPAddress server(192, 168, 100, 145);
IPAddress subnet(255, 255, 255, 0);
IPAddress dnsAdd(192,168,100,2);
UIPClient client;

void setup() {
  setupDHT();
  setupConnectivity();
}

void setupDHT() {
  Serial.begin(9600);
  while (!Serial) {
    ; // Esperar a porta serial
  }
  Serial.println("Inicializando DHT");
  dht.begin();
}

void setupConnectivity() {
  Ethernet.begin(mac, ip, dnsAdd, gateway, subnet);
  Serial.println(Ethernet.localIP());
  delay(1000);
  Serial.println("Conectando...");
  if (client.connect(server, 15555)) {
    Serial.println("Conectado!");
  } else {
    Serial.println("Falha ao conectar.");
    Serial.println(Ethernet.localIP());
  }
}

void loop() {
  delay(1000);
  senseData();
}

void senseData() {
  float umidade = dht.readHumidity();
  float temperatura = dht.readTemperature();

  if (isnan(temperatura) || isnan(umidade)) {
    Serial.println("Há um erro com algum dos valores retornados");
  } else {
    sendData(umidade, temperatura);
  }
}

void sendData(float umidade, float temperatura) {
  //Todo: send data
  Serial.println("Send data");
  String message = "humidity:";
  message.concat(umidade);
  message.concat(";temperature:");
  message.concat(temperatura);
  message.concat(";identifier:");
  message.concat(id);
  if (client.connected()) {
      Serial.println("Disponível");
      client.println(message);
      client.println();
      char c = client.read();
      Serial.print(c);
  } else {
    Serial.println("Indisponível Reconectando...");
    if (client.connect(server, 15555)) {
      Serial.println("Conectado!");
    } else {
      Serial.println("Falha ao conectar.");
      Serial.println(Ethernet.localIP());
    }
    
  }
}

