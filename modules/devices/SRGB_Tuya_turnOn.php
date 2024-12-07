<?php
/*
# **Ледлампа(RGB) с управлением яркостью и цветом.**
## **Простое устройство для MajorDomo.**  
Добавление в MajorDomo простого устройства для Ледлампа(RGB) с управлением яркостью и цветом.   
С режимом включеня по датчику освещения, восходу/закату солнца или по установленному времени.  
Автовыключение по заданному времени.С заданными яркостью и цветом для дня и ночи.  
Включение по времени суток(Ночь,День,Кгуглосуточно)

**Надо привязать свойства:**

- **brightnessWork - brightness лампочки.**
  - Добавить Путь (write): zigbee2mqtt/Название устройства/set/brightness
- **colorWork - color лампочки.**
  - Добавить Путь (write): zigbee2mqtt/Название устройства/set/color
- **status - state лампочки.**
  - В статус не добовляем путь(write) так как он нужен только для обратной связи
    что бы знать включена или нет лапочка для сцен или кнопок.
- **Установить инимальные и максимальные рабочие уровни для яркости:**
  - Например для лампочек Xiaomi ZigBee это:
   - brightnessWorkMax - 254
   - brightnessWorkMin - 0

### **ОБЫЧНЫЙ РЕЖИМ:**

Включить - callMethod('имя объекта '.'turnOn');  
Если без параметров установит то что в brightnessSaved и colorSeved.  
Если brightnessSaved и colorSeved пусто то на полную яркость(100%) и белый цвет(#FFFFFF).  

С параметрами:
- callMethod('имя объекта.turnOn', array('brightness'=> 1<-->100, 'color'=> '#------');  
- callMethod('имя объекта.turnOn', array('brightness'=> 1<-->100));  
- callMethod('имя объекта.turnOn', array('color'=> '#------');  

**Устанавливается flag=1. Стопер который не дает запускаться методу AutoOFF.**

### **РЕЖИМ ПОДСВЕТКИ:**

Включить ночной режим - callMethod('имя объекта.turnOn', array('dayNight'=>1));  
- Включится на время которое указано в timerOFF(сек). Если 0 то включится но сам не выключится.  
- Если в presence(например данные с датчика присутствия) 1 то не выключится.  
  - Как только в presence изменися с 1 на 0 запустится метод автовыключения(AutoOFF).    
- Можно включать режим подсветки Днем,Ночью или весь день.  
  - если в workInDai:   
    + 0-Весь день.(Ночью ночные установки яркости и теплоты. Днем дневные.)  
    + 1-Днем  
    + 2-Ночью  
- Включать по солнцу(bySunTime):  
  - после захода - ночные установки яркости (nightBrightness) и цвета (nightColor).  
  - после восхода - дневные (dayBrightness, dayColor).  
  - Надо обязательно писать в свойства sunriseTime и sunsetTime время восхода и заката.  
    Если не указано, то то, что указано - в ручную(byManually).  
  - К восходу и закату можно прибавить или отнять время если надо чтобы включалось или выключалось раньше или позже:
    - addTimeSunrise - к рассвету в формате 05:30 (5 часов 30 минут)
      - signSunrise:  0 - отнять 1 - прибавить.
    - addTimeSunset  - к закату в формате 00:30 (30 минут)
      - signSunset:  0 - отнять 1 - прибавить.  
- Включать вручную(byManually):  
    - после начало ночь - ночные установки яркости и теплоты.  
    - после начло день - дневные.  
- Включать по датчику(bySensor):  
    - Только ночные установки яркости и теплоты.  
      (Если надо можно дописать разные установки для дня и ночи.)  
    - В свойство illuminance надо писать данные с датчика освещения.  
      - если illuminance меньше чем установленно в illuminanceMax подсветка включится.  
    - ***Работу по датчику освещения не проверял так как не имеется в наличии.***  
- **Можно запустить режим подсветки с параметпами:**
  - callMethod('имя объекта.turnOn', array('dayNight'=>1, 'brightness'=> 1<--> 100,'color'=> '#------'));


**Устанавливается flag=0. Запускается метод AutoOFF.**

## **Методы:**

- **brightnessDown**  
  - Уменьшить яркость.(array("value"=>1-50)). Без  параметров -10.
- **brightnessUp**  
  - Увеличить яркость.(array("value"=>1-50)). Без  параметров 10.
- **byDefault** 
  - Установит параметры по дефолту. Это если что-то пошло не так.  
    (При первом запуске метода turnOn тоже все выставится по дефолту.)
- **CommandsMenu** 
  - Создаст меню данного объекта в "Меню Управления"

При первом запуске метода **turnOn** все нужные свойства для работы метода должны прописаться сами.  
Если нужны другие то можно изменить в ручную в свойствах объекта или запустить метод CommandsMenu.  
Он сам создаст меню в "**Меню Управления**" и там можно все удобно настроить.  
Меню будет называться по имени объекта. При желании можно изменить на любое другое.  

Было проверено на Ледленте [Tuta Zigbee RGB light](https://www.zigbee2mqtt.io/devices/TS0503B.html "zigbee2mqtt.io")  

*/

if ($this->getProperty('dayBrightness') == '') $this->setProperty('dayBrightness', '100');
if ($this->getProperty('dayColor') == '') $this->setProperty('dayColor', '#FFFFFF');
if ($this->getProperty('nightBrightness') == '') $this->setProperty('nightBrightness', '10');
if ($this->getProperty('nightColor') == '') $this->setProperty('nightColor', '#FFD700');
if ($this->getProperty('brightnessWorkMin') == '') $this->setProperty('brightnessWorkMin', '0');
if ($this->getProperty('brightnessWorkMax') == '') $this->setProperty('brightnessWorkMax', '254');
if ($this->getProperty('timerOFF') == '') $this->setProperty('timerOFF', '120');
if ($this->getProperty('presence') == '') $this->setProperty('presence', '0');
if ($this->getProperty('dayBegin') == '') $this->setProperty('dayBegin', '08:00');
if ($this->getProperty('nightBegin') == '') $this->setProperty('nightBegin', '18:00');
if ($this->getProperty('autoOnOff') == '') $this->setProperty('autoOnOff', '1');
if ($this->getProperty('flag') == '') $this->setProperty('flag', '0');
if ($this->getProperty('illuminanceFlag') == '') $this->setProperty('illuminanceFlag', '0');
if ($this->getProperty('illuminance') == '') $this->setProperty('illuminance', '0');
if ($this->getProperty('illuminanceMax') == '') $this->setProperty('illuminanceMax', '0');
if ($this->getProperty('bySensor') == '') $this->setProperty('bySensor', '0');
if ($this->getProperty('byManually') == '') $this->setProperty('byManually', '1');
if ($this->getProperty('bySunTime') == '') $this->setProperty('bySunTime', '0');
if ($this->getProperty('workInDai') == '') $this->setProperty('workInDai', '2');
if ($this->getProperty('addTimeSunrise') == '') $this->setProperty('addTimeSunrise', '00:00');
if ($this->getProperty('addTimeSunset') == '') $this->setProperty('addTimeSunset', '00:00');
if ($this->getProperty('signSunrise') == '') $this->setProperty('signSunrise', '1');
if ($this->getProperty('signSunset') == '') $this->setProperty('signSunset', '1');
if ($this->getProperty('sunriseTime') == '') $this->setProperty('sunriseTime', $this->getProperty('dayBegin'));
if ($this->getProperty('sunsetTime') == '') $this->setProperty('sunsetTime', $this->getProperty('nightBegin'));


if (isset($params['brightness']) &&  $params['brightness'] == 0) {
  $this->callMethod('turnOff');
  return;
}

$color = isset($params['color']) ? $params['color'] : 0;
$brightness = isset($params['brightness']) && $params['brightness'] > 0 && $params['brightness'] <= 100 ? $params['brightness'] : 0;
$dayNight = isset($params['dayNight']) && $params['dayNight'] == 1 ? 1 : 0;
$brightnessSaved = $this->getProperty('brightnessSaved');
$colorSaved = $this->getProperty('colorSaved');

$dayBegin;
$nightBegin;

if (!$dayNight) {
  $this->setProperty('flag', 1);
  $this->setProperty('status', 1);
  if ($color) {
    $this->setProperty('color', $color);
  } else if ($colorSaved) {
    $this->setProperty('color', $colorSaved);
  } else {
    $this->setProperty('color', '#FFFFFF');
  }

  if ($brightness) {
    $this->setProperty('brightness', $brightness);
  } else if ($brightnessSaved) {
    $this->setProperty('brightness', $brightnessSaved);
  } else {
    $this->setProperty('brightness', 100);
  }
}

if ($dayNight && !$this->getProperty('flag')) {

  if ($this->getProperty('bySunTime') && $this->getProperty('sunriseTime') != '' && $this->getProperty('sunsetTime') != '') {
    $dayBegin = edit_time($this->getProperty('sunriseTime'), $this->getProperty('addTimeSunrise'), $this->getProperty('signSunrise'));
    $nightBegin = edit_time($this->getProperty('sunsetTime'), $this->getProperty('addTimeSunset'), $this->getProperty('signSunset'));
  } else if (!$this->getProperty('bySensor')) {
    $dayBegin = $this->getProperty('dayBegin');
    $nightBegin = $this->getProperty('nightBegin');
  }
  if ($this->getProperty('autoOnOff')) {
    if (($this->getProperty('workInDai') == '2' || $this->getProperty('workInDai') == '0') && !$this->getProperty('bySensor') && timeBetween($nightBegin, $dayBegin)) {
      $this->setProperty('brightness', $brightness ? $brightness : $this->getProperty('nightBrightness'));
      $this->setProperty('color', $color ? $color : $this->getProperty('nightColor'));
    } else if (($this->getProperty('workInDai') == '1' || $this->getProperty('workInDai') == '0') && !$this->getProperty('bySensor') && timeBetween($dayBegin, $nightBegin)) {
      $this->setProperty('brightness', $brightness ? $brightness : $this->getProperty('dayBrightness'));
      $this->setProperty('color', $color ? $color : $this->getProperty('dayColor'));
    } else if (($this->getProperty('bySensor') && $this->getProperty('illuminance') <= $this->getProperty('illuminanceMax')) || $this->getProperty('illuminanceFlag')) {
      $this->setProperty('brightness', $brightness ? $brightness : $this->getProperty('nightBrightness'));
      $this->setProperty('color', $color ? $color : $this->getProperty('nightColor'));
      $this->setProperty('illuminanceFlag', 1);
    }
    $this->callMethod('AutoOFF');
  }
  function edit_time($time, $addTime, $sign)
  {
    $part = explode(':', $addTime);
    $addTime_sec = $part[0] * 3600 + $part[1] * 60 + $part[2];
    if (!$sign) {
      $addTime_sec = $addTime_sec * -1;
    }
    $res = strtotime($time) + $addTime_sec;
    return date('H:i', $res);
  }
}
