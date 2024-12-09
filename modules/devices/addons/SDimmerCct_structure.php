<?php

if (SETTINGS_SITE_LANGUAGE && file_exists(ROOT . 'languages/SDimmerCct_' . SETTINGS_SITE_LANGUAGE . '.php')) {
	include_once(ROOT . 'languages/SDimmerCct_' . SETTINGS_SITE_LANGUAGE . '.php');
} else {
	include_once(ROOT . 'languages/SDimmerCct_default.php'); //
}

$this->device_types['dimmer'] = array(
	'TITLE' => 'Освещение (Яркость,Температура)',
	'PARENT_CLASS' => 'SDimmers',
	'CLASS' => 'SDimmerCct',
	'PROPERTIES' => array(
		'addTimeSunrise' => array('DESCRIPTION' => 'Добавить к восходу(00:00)'),
		'addTimeSunset' => array('DESCRIPTION' => 'Добавить к закату(00:00)'),
		'signSunrise' => array('DESCRIPTION' => 'Прибавить/отнять к/от восхода солнца: 1-прибавить, 0-отнять'),
		'signSunset' => array('DESCRIPTION' => 'Прибавить/отнять к/от заката солнца: 1-прибавить, 0-отнять'),
		'sunriseTime' => array('DESCRIPTION' => 'Время восхода солнца.'),
		'sunsetTime' => array('DESCRIPTION' => 'Время захода солнца.'),
		'autoOnOff' => array('DESCRIPTION' => 'Автовключение: 0-не включать 1-включать'),
		'timerOFF' => array('DESCRIPTION' => 'Задержка перед выключением(сек). 0-не выключать.'),
		'workInDai' => array('DESCRIPTION' => 'работать: 0-24 часа. 1-Днем. 2-Ночью.'),
		'byManually' => array('DESCRIPTION' => 'Включать по заданному времени: 0-Выключить. 1-Включить.', 'ONCHANGE' => 'switchByManually'),
		'bySensor' => array('DESCRIPTION' => 'Включать по датчику света: 0-Отключить. 1-Включить.', 'ONCHANGE' => 'switchBySensor'),
		'bySunTime' => array('DESCRIPTION' => 'Включать по солнцу: 0-Выключить. 1-Включить.', 'ONCHANGE' => 'switchBySunTime'),
		'dayBegin' => array('DESCRIPTION' => 'Начало режима день (hh:mm)'),
		'nightBegin' => array('DESCRIPTION' => 'Начало режима ночь (hh:mm)'),
		'presence' => array('DESCRIPTION' => 'Данные с датчика присутствия', 'ONCHANGE' => 'presenceUpdated', 'DATA_KEY' => 1),
		'flag' => array('DESCRIPTION' => 'Стопер'),
		'illuminanceFlag' => array('DESCRIPTION' => 'Стопер датчика освещения'),
		'illuminance' => array('DESCRIPTION' => 'Данные с датчика освещения.', 'DATA_KEY' => 1),
		'illuminanceMax' => array('DESCRIPTION' => 'Максимальное освещение.Если меньше включается свет.'),
		'dayLevel' => array('DESCRIPTION' => 'Уровень яркости днем (1<-->100)'),
		'dayCctLevel' => array('DESCRIPTION' => 'Уровень температуры днем (1<-->100)'),
		'nightLevel' => array('DESCRIPTION' => 'Уровень яркости ночью(1<-->100)'),
		'nightCctLevel' => array('DESCRIPTION' => 'Уровень температуры днем (1<-->100)'),

		'level' => array('DESCRIPTION' => 'Яркость (0<-->100)', 'ONCHANGE' => 'levelChanged', 'DATA_KEY' => 1),
		'cctLevel' => array('DESCRIPTION' => 'Уровень температуры: (0<-->100)', 'ONCHANGE' => 'cctLevelChanged', 'DATA_KEY' => 1),
		
		'maxWork' => array('DESCRIPTION' => 'Максимальная рабочая яркость.', '_CONFIG_TYPE' => 'num'),
		'minWork' => array('DESCRIPTION' => 'Минимальная рабочая яркость.', '_CONFIG_TYPE' => 'num'),
		'cctWorkMax' => array('DESCRIPTION' => 'Максимальная рабочая теплота.', '_CONFIG_TYPE' => 'num'),
		'cctWorkMin' => array('DESCRIPTION' => 'Минимальная рабочая теплота.', '_CONFIG_TYPE' => 'num'),
		'levelSaved' => array('DESCRIPTION' => 'Сохраненная(предыдущая) яркость.', '_CONFIG_TYPE' => 'num'),
		'cctSeved' => array('DESCRIPTION' => 'Сохраненная(предыдущая) теплота.', '_CONFIG_TYPE' => 'num'),
		'levelWork' => array('DESCRIPTION' => 'Рабочая яркость.', 'ONCHANGE' => 'levelWorkChanged', '_CONFIG_TYPE' => 'num'),
		'cctWork' => array('DESCRIPTION' => 'Рабочая теплота.', 'ONCHANGE' => 'cctWorkChanged', '_CONFIG_TYPE' => 'num'),
		
		

	),
	'METHODS' => array(
		'AutoOFF' => array('DESCRIPTION' => 'Автовыключение (timerOFF) 0 не включает.'),
		'levelDown' => array('DESCRIPTION' => 'Уменьшить уровень яркости.(array(\'value\'=>1-50)) Без параметров -10.', '_CONFIG_SHOW' => 1, '_CONFIG_REQ_VALUE' => 1),
		'levelUp' => array('DESCRIPTION' => 'Увеличить уровень яркости.(array(\'value\'=>1-50)) Без параметров +10.', '_CONFIG_SHOW' => 1, '_CONFIG_REQ_VALUE' => 1),
		'cctLevelDown' => array('DESCRIPTION' => 'Уменьшить уровень температуры.(array(\'value\'=>1-50)) Без параметров -10.', '_CONFIG_SHOW' => 1, '_CONFIG_REQ_VALUE' => 1),
		'cctLevelUp' => array('DESCRIPTION' => 'Увеличить уровень температуры.(array(\'value\'=>1-50)) Без параметров +10.', '_CONFIG_SHOW' => 1, '_CONFIG_REQ_VALUE' => 1),
		'byDefault' => array('DESCRIPTION' => 'Установить свойства по умолчанию.'),
		'cctPreset' => array('DESCRIPTION' => 'Цветовые пресеты.(array(\'value\'=>\'C\'-cold,\'N\'-neutral,\'W\'-warmest))', '_CONFIG_SHOW' => 1, '_CONFIG_REQ_VALUE' => 1),
		'CommandsMenu' => array('DESCRIPTION' => 'Создает меню управления.(Запускать 1 раз для каждого объекта).', '_CONFIG_SHOW' => 1),
		'presenceUpdated' => array('DESCRIPTION' => 'Запускается при изменении свойства presence'),
		'setLevel' => array('DESCRIPTION' => 'Установить уровень яркости.(array(\'value\'=> 0<-->100)) Без  параметров то что в levelSaved. Если levelSaved пусто то 100.', '_CONFIG_SHOW' => 1, '_CONFIG_REQ_VALUE' => 1),
		'setCctLevel' => array('DESCRIPTION' => 'Установить уровень температуры.(array(\'value\'=> 0<-->100)) Без  параметров то что в cctSeved. Если cctSeved пуст то 0.', '_CONFIG_SHOW' => 1, '_CONFIG_REQ_VALUE' => 1),
		'switch' => array('DESCRIPTION' => 'Переключить', '_CONFIG_SHOW' => 1),
		'switchByManually' => array('DESCRIPTION' => 'При включении вручную отключить по солнцу и по датчику.'),
		'switchBySensor' => array('DESCRIPTION' => 'При включении сенсора света отключить по солнцу и вручную.'),
		'switchBySunTime' => array('DESCRIPTION' => 'При включении по солнцу отключить по датчику света и вручную.'),
		'turnOn' => array('DESCRIPTION' => 'ВключитЬ', '_CONFIG_SHOW' => 1),
		'turnOff' => array('DESCRIPTION' => 'Выключить', '_CONFIG_SHOW' => 1),
		'levelChanged' => array('DESCRIPTION' => 'Запускается при смене яркости'),
		'cctLevelChanged' => array('DESCRIPTION' => 'Запускается при смене цвета температуры'),
		'levelWorkChanged' => array('DESCRIPTION' => 'Запускается при смене рабочей яркости'),
		'cctWorkChanged' => array('DESCRIPTION' => 'Запускается при смене цвета рабочей температуры'),
	),
);
