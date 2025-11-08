# Лампочки с управлением яркостью и цветовой температурой

## Простое устройство для MajorDomo
Добавляет устройство для управления лампочками с возможностью регулировки яркости и цветовой температуры.  
Расширяет встроенный класс `SDimmers`.

---

## Свойства

- **levelWork** – привязка к яркости лампочки (`brightness`)  
  - Путь (write): `zigbee2mqtt/Название_устройства/set/brightness`  
- **cctWork** – привязка к цветовой температуре (`color_temp`)  
  - Путь (write): `zigbee2mqtt/Название_устройства/set/color_temp`  
- **status** – привязка к состоянию лампочки (`state`)  
  - Путь (write): `zigbee2mqtt/Название_устройства/set/state`  
  - Replace list: `ON=1`, `OFF=0`  
- **level** – яркость лампочки в процентах (0–100)  
- **levelSaved** – последняя сохранённая яркость (0–100)  
- **cct** – цветовая температура в процентах (0–100)  
- **cctSaved** – последняя сохранённая цветовая температура (0–100)  

---

## Минимальные и максимальные рабочие уровни

- **levelMinWork / levelMaxWork** – минимальная и максимальная рабочая яркость  
- **cctMinWork / cctMaxWork** – минимальная и максимальная рабочая температура  

**Примеры диапазонов:**

**Xiaomi ZigBee**  
- levelMinWork: 0, levelMaxWork: 254  
- cctMinWork: 153, cctMaxWork: 370  

**Tuta ZigBee**  
- levelMinWork: 0, levelMaxWork: 254  
- cctMinWork: 153, cctMaxWork: 500  

---

## Методы

- **turnOn** – включить лампочку  
  ```php
  callMethod('имя_объекта.turnOn');
  ```  
- **turnOff** – выключить лампочку  
  ```php
  callMethod('имя_объекта.turnOff');
  ```  
- **switch** – переключить состояние лампочки  
  ```php
  callMethod('имя_объекта.switch');
  ```  
- **setLevel** – установить яркость (0–100%)  
  ```php
  setLevel(array("value" => 0..100));
  ```  
- **setCct** – установить цветовую температуру (0–100%)  
  ```php
  setCct(array("value" => 0..100));
  ```  
- **levelDown** – уменьшить яркость (по умолчанию на 10%, можно указать `value` 1–100)  
- **levelUp** – увеличить яркость (по умолчанию на 10%, можно указать `value` 1–100)  
- **cctDown** – уменьшить цветовую температуру (по умолчанию на 10%, можно указать `value` 1–100)  
- **cctUp** – увеличить цветовую температуру (по умолчанию на 10%, можно указать `value` 1–100)  

---

## Совместимость

Проверено на:  
- [Xiaomi ZigBee (ZNLDP12LM)](https://www.zigbee2mqtt.io/devices/ZNLDP12LM.html#aqara-znldp12lm)  
- [Потолочная лампа Tuta ZigBee (ZB-LZD10-RCW)](https://www.zigbee2mqtt.io/devices/ZB-LZD10-RCW.html#moes-zb-lzd10-rc)