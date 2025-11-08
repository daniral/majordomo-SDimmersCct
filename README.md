# **Лампочки с управлением яркостью и теплотой цвета.**  
## **Простое устройство для MajorDomo.**   
Добавление в MajorDomo простого устройства для лампочек с управлением яркостью и теплотой цвета.   
Расширяет встроенный класс SDimmers.  

**Свойства:**  

- **levelWork - привязать к brightness лампочки.**  
  - Добавить Путь (write): zigbee2mqtt/Название устройства/set/brightness  
- **cctWork - привязать к color_temp лампочки.**  
  - Добавить Путь (write): zigbee2mqtt/Название устройства/set/color_temp  
- **status - привязать к state лампочки.**  
  - Добавить Путь (write): zigbee2mqtt/Название устройства/set/state  
  - Написать в Replace list: ON=1,OFF=0  
- **level - Яркость лампочки в процентах (0..100).**  
- **levelSaved - Последняя яркость лампочки в процентах (0..100).**  
- **cct - Теплота лампочки в процентах (0..100).**  
- **cctSaved - Последняя теплота лампочки в процентах (0..100).**  

- ## **Указать минимальные и максимальные рабочие уровни для яркости и теплоты:**  
- **levelMaxWork - Максимальная рабочая яркость.**  
- **levelMinWork - Минимальная рабочая яркость.**  
- **cctMaxWork - Максимальная рабочая теплота.**  
- **cctMinWork - Минимальная рабочая теплота.**  

**Для лампочек Xiaomi ZigBee**  

- maxWork - 254  
- minWork - 0  
- cctMaxWork - 370  
- cctMinWork - 153  

**Для для лампочек Tuta ZigBee**  

- maxWork - 254  
- minWork - 0  
- cctMaxWork - 500  
- cctMinWork - 153  

## **МЕТОДЫ:**  

- **turnOn**   
  - Включить - callMethod('имя объекта '.'turnOn');  
- **turnOff**  
  - Выключить - callMethod('имя объекта '.'turnOff');  
- **switch**  
  - Выключить - callMethod('имя объекта '.'switch');  
- **setLevel**   
  - Установить яркость света.(array("value"=> 0 <--> 100 %))  
- **setCct**   
  - Установить температуру.(array("value"=>0 <--> 100 %))  
- **levelDown**  
  - Уменьшить яркость.(array("value"=>1..100)). Без  параметров 10.  
- **levelUp**  
  - Увеличить яркость.(array("value"=>1..100)). Без  параметров 10.  
- **cctDown**  
  - Уменьшить температуру.(array("value"=>1..100)). Без  параметров 10.  
- **cctUp**  
  - Увеличить температуру.(array("value"=>1..100)). Без  параметров 10.  


Было проверено на лампочках [Xiaomi ZigBee](https://www.zigbee2mqtt.io/devices/ZNLDP12LM.html#aqara-znldp12lm "zigbee2mqtt.io")  
И на потолочной лампе [Tuta ZigBee](https://www.zigbee2mqtt.io/devices/ZB-LZD10-RCW.html#moes-zb-lzd10-rc "zigbee2mqtt.io")  
