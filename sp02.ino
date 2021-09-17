#include <Wire.h>
#include <DFRobot_MAX30102.h>
#include <ESP8266WiFi.h>
#include <ESP8266HTTPClient.h>

DFRobot_MAX30102 particleSensor; //การกำหนดค่าให้เซ็นเซอร์

String thingSpeakAddress= "http://api.thingspeak.com/update?";
String writeAPIKey;
String tsfield1Name;
String request_string;
String api_key = "D246BSJJIF7OBZV8";
//เซ็ตค่าให้ Thingspeak

WiFiClient client; //เรียกใช้โมดูล WiFi

void init_wifi() {
   WiFi.begin("3bb-Maldives","mk250363");
  do {
    Serial.print(".");
    delay(500);
  } while ((!(WiFi.status() == WL_CONNECTED)));Serial.println("WiFi Connected");
  Serial.print("IP address: ");
  Serial.println((WiFi.localIP().toString()));
}
/*การกำหนดชื่อและรหัส WIFi เพื่อชื่อมต่อและให้ปริ้น จุดไปเรื่อย ๆ จนกว่าจะเชื่อมต่อได้ */
void setup()
{
  Serial.begin(115200); //เว็ตค่าให้ Serial
  init_wifi(); //เรียกใช้ Function WiFi
  while (!particleSensor.begin()) {
    Serial.println("MAX30102 was not found");
    delay(1000);
  }
  particleSensor.sensorConfiguration(50, SAMPLEAVG_4, MODE_MULTILED, SAMPLERATE_100, PULSEWIDTH_411, ADCRANGE_16384); /*ใช้คำจำกัดความมาโครเพื่อกำหนดค่าให้เซ็นเซอร์
     *ความสว่างเริ่มต้น LED : 0x1F(6.4mA), ช่วง: 0~255(0=ปิด, 255=50mA)
   *sampleAverage เฉลี่ยตัวอย่างหลายตัวอย่างแล้วแสดงครั้งเดียว ลดปริมาณข้อมูล ค่าเริ่มต้น 4 samples average
   *ledMode โหมด LED ค่าเริ่มต้นจะใช้แสงสีแดงและ IR ในเวลาเดียวกัน
   *sampleRate อัตราการสุ่มตัวอย่าง ค่าเริ่มต้น 400 samples ทุกวินาที
   *pulseWidth ความกว้างของพัลส์ ยิ่งความกว้างพัลส์ยาวเท่าใด ระยะการตรวจจับก็จะกว้างขึ้นเท่านั้น ค่าเริ่มต้นเป็นช่วงสูงสุด
   *adcRange ช่วงการวัด ADC, ค่าเริ่มต้น 4096 (nA), 15.63(pA) ต่อ  LSB */
}

int32_t SPO2; 
int8_t SPO2Valid; //ตั้งค่าสถานะเพื่อแสดงหากการคำนวณ SPO2 ถูกต้อง
int32_t heartRate; 
int8_t heartRateValid; //ตั้งค่าสถานะเพื่อแสดงหากการคำนวณ heartRate ถูกต้อง
HTTPClient http;//เชื่อมต่อโปรคอล WiFi

void loop()
{
  Serial.println(F("Wait about four seconds"));
  particleSensor.heartrateAndOxygenSaturation(&SPO2,&SPO2Valid,&heartRate,&heartRateValid); //ใช้มาโครกำหนดค่าให้ตัวแปรเซ็นเซอร์ 
  
  Serial.print(F("heartRate="));
  Serial.print(heartRate, DEC);
  Serial.print(F(", heartRateValid="));
  Serial.print(heartRateValid, DEC);
  Serial.print(F("; SPO2="));
  Serial.print(SPO2, DEC);
  Serial.print(F(", SPO2Valid="));
  Serial.println(SPO2Valid, DEC);
//ปริ้นค่าออกทาง Serial 

  if(heartRateValid == 1 && SPO2Valid == 1){ //หากผู้ใช้มีการวางนิ้วที่เว็นเซอร์ค่าที่ได้จะส่งขึ้น Thingspeak ทันที แต่หากไม่ได้วางนิ้วก็จะไม่ส่งค่า
    
   if (client.connect("api.thingspeak.com",80)) {
      request_string = thingSpeakAddress;
      request_string += "key=";
      request_string += api_key;
      request_string += "&field1=";
      request_string += heartRate;
      request_string += "&field2=";
      request_string += SPO2;
      
      http.begin(client,request_string);
      http.GET();
      http.end();
      request_string="";
       }
  delay(15000);
  }
}
