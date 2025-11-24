<?php
/**
 * Устанавливает свойства объекта лампы по умолчанию.
 *
 * Значения подходят для AqaraBulbZigBee. Для других устройств могут потребоваться изменения.
 *
 * Устанавливаются следующие свойства:
 *   - level: яркость лампы (0–100)
 *   - cct: цветовая температура (0–100)
 *   - levelMinWork / levelMaxWork: минимальная и максимальная яркость
 *   - cctMinWork / cctMaxWork: минимальная и максимальная температура
 *
 * @return void
 */
$defaults = [
	'level' => '50', 'cct' => '50',
    'levelMinWork' => '1', 'levelMaxWork' => '254',
    'cctMinWork' => '153', 'cctMaxWork' => '370',
];
initDefaults($this, $defaults);