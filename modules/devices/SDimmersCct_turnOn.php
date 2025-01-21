<?php
/*
# **Лампочки с управлением яркостью и теплотой цвета.**  
## **Простое устройство для MajorDomo.**   
Добавление в MajorDomo простого устройства для лампочек с управлением яркостью и теплотой цвета.   
Расширяет встроенный класс SDimmers.  
С авто режимом включеня по датчику освещения, восходу/закату солнца или по установленному времени.  
С заданными яркостью и теплотой для дня и ночи.  
Автовыключение через заданное времени.  
Авто режим для Дня, Ночи или в течении всего деня.  

**Привязка свойства:**  

- **levelWork - brightness лампочки.**  
  - Добавить Путь (write): zigbee2mqtt/Название устройства/set/brightness  
- **cctWork - color_temp лампочки.**  
  - Добавить Путь (write): zigbee2mqtt/Название устройства/set/color_temp  
- **status - state лампочки.**  
  - Добавить Путь (write): zigbee2mqtt/Название устройства/set/state  
  - Написать в Replace list: ON=1,OFF=0  
  - Указать минимальные и максимальные рабочие уровни для яркости и теплоты:  

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

### **ОБЫЧНЫЙ РЕЖИМ:**  

Включить - callMethod('имя объекта '.'turnOn');  
Если без параметров установит то что в levelSaved и cctSeved.  
Если levelSaved и cctSeved пусто то на полную яркость(100%) и холодный цвет(0%).  

С параметрами:  
- callMethod('имя объекта.turnOn', array('level'=> 1<-->100, 'cctLevel'=> 0<-->100));  
- callMethod('имя объекта.turnOn', array('level'=> 1<-->100));  
- callMethod('имя объекта.turnOn', array('cctLevel'=> 0<-->100));  
  - Вместо процентов можно вызвать пресеты:'cool','neutral','warm'.   

**Устанавливается flag=1. Стопер который не дает запускаться авто режиму и методу AutoOff.**  

### **АВТО РЕЖИМ:**  

Включить авто режим - callMethod('имя объекта.turnOn', array('autoMode'=>1)) - к пимеру запускать по датчику движения;   
- Включится на время которое указано в timerOff(сек). Если 0 то включится но сам не выключится.  
- Если в presence(например данные с датчика присутствия) 1 то не выключится.  
  - Как только в presence изменися с 1 на 0 запустится метод автовыключения(AutoOff).    
- Можно включать авто режим для Дня, Ночи или в течении всего деня.   
  - если в workingDay:   
    + 0 - Весь день.(Ночью ночные установки яркости и теплоты. Днем дневные.)  
    + 1 - Днем  (дневные установки)  
    + 2 - Ночью  (ночные установки)  
- Авто режим по времени (workingBy=1):  
    - после начало ночь - ночные установки яркости и теплоты.  
    - после начло день - дневные.  
- Авто режим по солнцу (workingBy=2):  
  - после захода - ночные установки яркости (nightLevel) и теплоты (nightCct).  
  - после восхода - дневные (dayLevel, dayCct).  
  - Надо обязательно писать в свойства sunriseTime и sunsetTime время восхода и заката.  
    Если не указано, то то, что указано - по времени.  
  - К восходу и закату можно прибавить или отнять время если надо чтобы включалось или выключалось раньше или позже:  
    - addTimeSunrise - к рассвету в формате 05:30 (5 часов 30 минут)  
      - signSunrise 0 - отнять 1 - прибавить.  
    - addTimeSunset  - к закату в формате 00:30 (30 минут)  
      - signSunset 0 - отнять 1 - прибавить.  
- Авто режим по датчику (workingBy=3):  
    - Только ночные установки яркости и теплоты.  
      (Если надо можно дописать разные установки для дня и ночи.)   
      (Надо подумать про адаптивный свет.(после покупки датчика света))  
    - В свойство illuminance надо писать данные с датчика освещения.  
      - если illuminance меньше чем установленно в illuminanceMax подсветка включится.  
    - ***Работу по датчику освещения не проверял так как не имеется в наличии.***   
- **Можно запустить авто режим с параметрами:**  
  - callMethod('имя объекта.turnOn', array('autoMode'=>1, 'level'=> 1<--> 100,'cctLevel'=> 0<-->100));  

## **МЕТОДЫ:**  

- **turnOn**   
  - Включить - callMethod('имя объекта '.'turnOn');  
    - Если без параметров установит то что в levelSaved и cctSeved.  
    - Если levelSaved и cctSeved пусто то на полную яркость(100%) и холодный цвет(0%).  
    - **Устанавливается flag=1. Стопер который не дает запускаться авто режиму и методу AutoOff.**  
    - С параметрами:  
      - callMethod('имя объекта.turnOn', array('level'=> 1<-->100, 'cctLevel'=> 0<-->100));  
      - callMethod('имя объекта.turnOn', array('level'=> 1<-->100));  
      - callMethod('имя объекта.turnOn', array('cctLevel'=> 0<-->100));  
      - Вместо процентов можно вызвать пресеты:'cool','neutral','warm'.   
  - Включить авто режим - callMethod('имя объекта.turnOn', array('autoMode'=>1));   
    - С параметрами:
      - callMethod('имя объекта.turnOn', array('autoMode'=>1, 'level'=> 1<-->100, 'cctLevel'=> 0<-->100));  
      - callMethod('имя объекта.turnOn', array('autoMode'=>1, 'level'=> 1<-->100));  
      - callMethod('имя объекта.turnOn', array('autoMode'=>1, 'cctLevel'=> 0<-->100));  
      - Вместо процентов можно вызвать пресеты:'cool','neutral','warm'.   
- **turnOff**  
  - Выключить - callMethod('имя объекта '.'turnOff');  
    - Устанавливается flag = 0
    - Устанавливается illuminanceFlag = 0
- **setLevel**   
  - Установить яркость света.(array("value"=> 0 <--> 100 %))  
    - **flag=1** - авто режим и автовыключение не запустится.  
- **setCct**   
  - Установить температуру.(array("value"=>0 <--> 100 %))  
    - Вместо процентов можно вызвать пресеты:'cool','neutral','warm'.  
    - **flag=1** - авто режим и автовыключение не запустится.  
- **levelDown**  
  - Уменьшить яркость.(array("value"=>1--100)). Без  параметров -10.  
  - **flag=1** - авто режим и автовыключение не запустится.  
- **levelUp**  
  - Увеличить яркость.(array("value"=>1--100)). Без  параметров 10.  
  - **flag=1** - авто режим и автовыключение не запустится.  
- **cctDown**  
  - Уменьшить температуру.(array("value"=>1--100)). Без  параметров -10.  
  - **flag=1** - авто режим и автовыключение не запустится.  
- **cctUp**  
  - Увеличить температуру.(array("value"=>1--100)). Без  параметров 10.  
  - **flag=1** - авто режим и автовыключение не запустится.  
- **byDefault**  
  - Установит параметры по дефолту. Это если что-то пошло не так.  
    (При первом запуске метода turnOn тоже все выставится по дефолту.)  
- **commandsMenu**  
  - Создаст меню данного объекта в "Меню Управления"  

При первом запуске метода **turnOn** все нужные свойства для работы метода должны прописаться сами.  
Если нужны другие то можно изменить в ручную в свойствах объекта или запустить мктод commandsMenu.  
Он сам создаст меню в "**Меню Управления**" и там можно все удобно настроить.  
Меню будет называться по имени объекта. При желании можно изменить на любое другое.  

Было проверено на лампочках [Xiaomi ZigBee](https://www.zigbee2mqtt.io/devices/ZNLDP12LM.html#aqara-znldp12lm "zigbee2mqtt.io")  
И на потолочной лампе [Tuta ZigBee](https://www.zigbee2mqtt.io/devices/ZB-LZD10-RCW.html#moes-zb-lzd10-rc "zigbee2mqtt.io")  

*/
if ($this->getProperty('dayLevel') == '') $this->setProperty('dayLevel', '100');
if ($this->getProperty('dayCct') == '') $this->setProperty('dayCct', '0');
if ($this->getProperty('nightLevel') == '') $this->setProperty('nightLevel', '10');
if ($this->getProperty('nightCct') == '') $this->setProperty('nightCct', '100');
if ($this->getProperty('minWork') == '') $this->setProperty('minWork', '0');
if ($this->getProperty('maxWork') == '') $this->setProperty('maxWork', '254');
if ($this->getProperty('cctMinWork') == '') $this->setProperty('cctMinWork', '153');
if ($this->getProperty('cctMaxWork') == '') $this->setProperty('cctMaxWork', '370');
if ($this->getProperty('timerOff') == '') $this->setProperty('timerOff', '120');
if ($this->getProperty('presence') == '') $this->setProperty('presence', '0');
if ($this->getProperty('dayBegin') == '') $this->setProperty('dayBegin', '08:00');
if ($this->getProperty('nightBegin') == '') $this->setProperty('nightBegin', '18:00');
if ($this->getProperty('autoOnOff') == '') $this->setProperty('autoOnOff', '1');
if ($this->getProperty('flag') == '') $this->setProperty('flag', '0');
if ($this->getProperty('illuminanceFlag') == '') $this->setProperty('illuminanceFlag', '0');
if ($this->getProperty('illuminance') == '') $this->setProperty('illuminance', '0');
if ($this->getProperty('illuminanceMax') == '') $this->setProperty('illuminanceMax', '0');
if ($this->getProperty('workingDay') == '') $this->setProperty('workingDay', '2');
if ($this->getProperty('workingBy') == '') $this->setProperty('workingBy', '1');
if ($this->getProperty('addTimeSunrise') == '') $this->setProperty('addTimeSunrise', '00:00');
if ($this->getProperty('addTimeSunset') == '') $this->setProperty('addTimeSunset', '00:00');
if ($this->getProperty('signSunrise') == '') $this->setProperty('signSunrise', '1');
if ($this->getProperty('signSunset') == '') $this->setProperty('signSunset', '1');
if ($this->getProperty('sunriseTime') == '') $this->setProperty('sunriseTime', $this->getProperty('dayBegin'));
if ($this->getProperty('sunsetTime') == '') $this->setProperty('sunsetTime', $this->getProperty('nightBegin'));

if (isset($params['level']) &&  $params['level'] == 0) {
  $this->callMethod('turnOff');
  return;
}

$level = isset($params['level']) && $params['level'] > 0 && $params['level'] <= 100 ? $params['level'] : 0;
$levelSaved = $this->getProperty('levelSaved');
$cctLevel = isset($params['cctLevel']) && $params['cctLevel'] >= 0 && $params['cctLevel'] <= 100 ? $params['cctLevel'] : 0;
$cctSeved = $this->getProperty('cctSeved');
$autoMode = isset($params['autoMode']) && $params['autoMode'] == 1 ? 1 : 0;

$dayBegin;
$nightBegin;

if (!$autoMode) {
  if ($level) {
    $this->callMethod('setLevel', array('value' => $level));
  } elseif ($levelSaved) {
    $this->callMethod('setLevel', array('value' => $levelSaved));
  } else {
    $this->callMethod('setLevel', array('value' => 100));
  }
  if ($cctLevel) {
    $this->callMethod('setCct', array('value' => $cctLevel));
  } elseif ($cctSeved) {
    $this->callMethod('setCct', array('value' => $cctSeved));
  } else {
    $this->callMethod('setCct', array('value' => 0));
  }
  return;
}

if ($autoMode && !$this->getProperty('flag')) {
  if ($this->getProperty('workingBy') == '2' && $this->getProperty('sunriseTime') != '' && $this->getProperty('sunsetTime') != '' && $this->getProperty('sunriseTime') != $this->getProperty('sunsetTime')) {
    $dayBegin = dimmerEeditTime($this->getProperty('sunriseTime'), $this->getProperty('addTimeSunrise'), $this->getProperty('signSunrise'));
    $nightBegin = dimmerEeditTime($this->getProperty('sunsetTime'), $this->getProperty('addTimeSunset'), $this->getProperty('signSunset'));
  } else if ($this->getProperty('workingBy') != '3') {
    $dayBegin = $this->getProperty('dayBegin');
    $nightBegin = $this->getProperty('nightBegin');
  }
  if ($this->getProperty('autoOnOff')) {
    if (($this->getProperty('workingDay') == '2' || $this->getProperty('workingDay') == '0') && $this->getProperty('workingBy') != '3' && timeBetween($nightBegin, $dayBegin)) {
      $this->setProperty('level', $level ? $level : $this->getProperty('nightLevel'));
      $this->setProperty('cctLevel', $cctLevel ? $cctLevel : $this->getProperty('nightCct'));
    } else if (($this->getProperty('workingDay') == '1' || $this->getProperty('workingDay') == '0') && $this->getProperty('workingBy') != '3' && timeBetween($dayBegin, $nightBegin)) {
      $this->setProperty('level', $level ? $level : $this->getProperty('dayLevel'));
      $this->setProperty('cctLevel', $cctLevel ? $cctLevel : $this->getProperty('dayCct'));
    } else if (($this->getProperty('workingBy') == '3' && $this->getProperty('illuminance') <= $this->getProperty('illuminanceMax')) || $this->getProperty('illuminanceFlag')) {
      $this->setProperty('level', $level ? $level : $this->getProperty('nightLevel'));
      $this->setProperty('cctLevel', $cctLevel ? $cctLevel : $this->getProperty('nightCct'));
      $this->setProperty('illuminanceFlag', 1);
    }
    $this->callMethod('AutoOff');
  }
}

function dimmerEeditTime($time, $addTime, $sign)
{
  $part = explode(':', $addTime);
  $addTime_sec = $part[0] * 3600 + $part[1] * 60 + $part[2];
  if (!$sign) {
    $addTime_sec = $addTime_sec * -1;
  }
  $res = strtotime($time) + $addTime_sec;
  return date('H:i', $res);
}
