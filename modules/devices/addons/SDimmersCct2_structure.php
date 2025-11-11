<?php

if (SETTINGS_SITE_LANGUAGE && file_exists(ROOT . 'languages/SDimmersCct2_' . SETTINGS_SITE_LANGUAGE . '.php')) {
	include_once(ROOT . 'languages/SDimmersCct2_' . SETTINGS_SITE_LANGUAGE . '.php');
} else {
	include_once(ROOT . 'languages/SDimmersCct2_default.php'); //
}

$this->device_types['dimmerCct2'] = array(
	'TITLE' => 'Освещение2(Яркость,Температура)',
	'PARENT_CLASS' => 'SDimmers',
	'CLASS' => 'SDimmersCct2',
	'PROPERTIES' => array(
		'level' => array('DESCRIPTION' => 'Яркость (0<-->100)', 'ONCHANGE' => 'propertysUpdated', 'DATA_KEY' => 1,'VALIDATION_TYPE' => 1, 'VALIDATION_NUM_MIN' => 0, 'VALIDATION_NUM_MAX' => 100),
		'levelWork' => array('DESCRIPTION' => 'Рабочая яркость.', 'ONCHANGE' => 'worksUpdated'),
		'levelSaved' => array('DESCRIPTION' => 'Сохраненная яркость.','VALIDATION_TYPE' => 1, 'VALIDATION_NUM_MIN' => 0, 'VALIDATION_NUM_MAX' => 100),
		'levelMaxWork' => array('DESCRIPTION' => 'Максимальная рабочая яркость', '_CONFIG_TYPE' => 'num'),
		'levelMinWork' => array('DESCRIPTION' => 'Минимальная рабочая яркость', '_CONFIG_TYPE' => 'num'),
		'cct' => array('DESCRIPTION' => 'Уровень температуры: (0-100)', 'ONCHANGE' => 'propertysUpdated', 'DATA_KEY' => 1,'VALIDATION_TYPE' => 1, 'VALIDATION_NUM_MIN' => 0, 'VALIDATION_NUM_MAX' => 100),
		'cctWork' => array('DESCRIPTION' => 'Рабочая теплота.', 'ONCHANGE' => 'worksUpdated'),
		'cctSaved' => array('DESCRIPTION' => 'Сохраненная теплота.','VALIDATION_TYPE' => 1, 'VALIDATION_NUM_MIN' => 0, 'VALIDATION_NUM_MAX' => 100),
		'cctMaxWork' => array('DESCRIPTION' => 'Максимальная рабочая теплота', '_CONFIG_TYPE' => 'num'),
		'cctMinWork' => array('DESCRIPTION' => 'Минимальная рабочая теплота', '_CONFIG_TYPE' => 'num'),
		'dayLevel' => array('DESCRIPTION' => 'Уровень яркости днем', '_CONFIG_TYPE' => 'num','VALIDATION_TYPE' => 1, 'VALIDATION_NUM_MIN' => 0, 'VALIDATION_NUM_MAX' => 100),
		'nightLevel' => array('DESCRIPTION' => 'Уровень яркости ночью', '_CONFIG_TYPE' => 'num','VALIDATION_TYPE' => 1, 'VALIDATION_NUM_MIN' => 0, 'VALIDATION_NUM_MAX' => 100),
		'dayCct' => array('DESCRIPTION' => 'Уровень температуры днем', '_CONFIG_TYPE' => 'num','VALIDATION_TYPE' => 1, 'VALIDATION_NUM_MIN' => 0, 'VALIDATION_NUM_MAX' => 100),
		'nightCct' => array('DESCRIPTION' => 'Уровень температуры ночью', '_CONFIG_TYPE' => 'num','VALIDATION_TYPE' => 1, 'VALIDATION_NUM_MIN' => 0, 'VALIDATION_NUM_MAX' => 100),
		'autoOnOff' => array('DESCRIPTION' => 'Автовключение','_CONFIG_TYPE'=>'select','_CONFIG_OPTIONS'=>'1=Включено,0=Отключено'),
		'timerOff' => array('DESCRIPTION' => 'Выключить через(сек). 0-не выключать', '_CONFIG_TYPE' => 'num'),
		'workingDay' => array('DESCRIPTION' => 'Включать','_CONFIG_TYPE'=>'select','_CONFIG_OPTIONS'=>'1=Днём,2=Ночью,3=Круглосуточно'),
		'workingBy' => array('DESCRIPTION' => 'Работать по','_CONFIG_TYPE'=>'select','_CONFIG_OPTIONS'=>'1=Времени,2=Солнцу,3=Датчику'),
		'dayBegin' => array('DESCRIPTION' => 'Начало режима день(hh:mm)', '_CONFIG_TYPE' => 'num'),
		'nightBegin' => array('DESCRIPTION' => 'Начало режима ночь(hh:mm)', '_CONFIG_TYPE' => 'num'),
		'sunriseTime' => array('DESCRIPTION' => 'Время восхода солнца'),
		'sunsetTime' => array('DESCRIPTION' => 'Время захода солнца'),
		'signSunrise' => array('DESCRIPTION' => 'Восход','_CONFIG_TYPE'=>'select','_CONFIG_OPTIONS'=>'1=прибавить,0=отнять'),
		'addTimeSunrise' => array('DESCRIPTION' => 'Часов:Минут(00:00)', '_CONFIG_TYPE' => 'num'),
		'signSunset' => array('DESCRIPTION' => 'Закат','_CONFIG_TYPE'=>'select','_CONFIG_OPTIONS'=>'1=прибавить,0=отнять'),
		'addTimeSunset' => array('DESCRIPTION' => 'Часов:Минут(00:00)', '_CONFIG_TYPE' => 'num'),
		'illuminanceMax' => array('DESCRIPTION' => 'Макc.освещение(датчик)', '_CONFIG_TYPE' => 'num'),
		'illuminanceFlag' => array('DESCRIPTION' => 'Стопер датчика освещения'),
		'illuminance' => array('DESCRIPTION' => 'Данные с датчика освещения', 'DATA_KEY' => 1),
		'presence' => array('DESCRIPTION' => 'Данные с датчика присутствия', 'ONCHANGE' => 'propertysUpdated', 'DATA_KEY' => 1),
		'flag' => array('DESCRIPTION' => 'Стопер'),
	),
	'METHODS' => array(
		'turnOn' => array('DESCRIPTION' => 'Включить', '_CONFIG_SHOW' => 1),
		'turnOff' => array('DESCRIPTION' => 'Выключить', '_CONFIG_SHOW' => 1),
		'switch' => array('DESCRIPTION' => 'Переключить'),
		'setLevel' => array('DESCRIPTION' => 'Установить уровень яркости.', '_CONFIG_SHOW' => 1, '_CONFIG_REQ_VALUE' => 1),
		'setCct' => array('DESCRIPTION' => 'Установить уровень температуры.', '_CONFIG_SHOW' => 1, '_CONFIG_REQ_VALUE' => 1),
		'levelUp' => array('DESCRIPTION' => 'Увеличить уровень яркости.', '_CONFIG_SHOW' => 1, '_CONFIG_REQ_VALUE' => 1),
		'levelDown' => array('DESCRIPTION' => 'Уменьшить уровень яркости.', '_CONFIG_SHOW' => 1, '_CONFIG_REQ_VALUE' => 1),
		'cctUp' => array('DESCRIPTION' => 'Увеличить уровень температуры.', '_CONFIG_SHOW' => 1, '_CONFIG_REQ_VALUE' => 1),
		'cctDown' => array('DESCRIPTION' => 'Уменьшить уровень температуры.', '_CONFIG_SHOW' => 1, '_CONFIG_REQ_VALUE' => 1),
		'propertysUpdated' => array('DESCRIPTION' => 'Запускается при смене яркости,теплоты,присутствия'),
		'worksUpdated' => array('DESCRIPTION' => 'Запускается при смене рабочей яркости и цвета'),
		'byDefault' => array('DESCRIPTION' => 'Установить свойства по умолчанию.'),
		'commandsMenu' => array('DESCRIPTION' => 'Создает меню управления.', '_CONFIG_SHOW' => 1),
	),
);
