<?php
/**
 * normalizeRange($val, $min, $max) — Проверяет и нормализует значение (число или HEX) в заданный диапазон.
 * dimmerTime($time, $addTime, $sign) — Вычисляет новое время с поправкой (добавить/вычесть HH:MM).
 * autoOff($object, $timer, $flag, $presence) — Запускает таймер автоотключения лампы.
 * initDefaults($object, $defaults) — Инициализирует свойства объекта по умолчанию.
 * getAutoLevelCct($object, $level, $cct) — Получает текущие значения яркости и CCT для авто режима.
 * adjustProperty($obj, $property, $value, $direction, $defaultStep, $min, $max) — Универсальное изменение свойства (увеличить/уменьшить).
 * createObjectMenu($objectName, $menuItems, $parentId, $insertID, $depth) — Создает меню управления объектом рекурсивно.
 * 
 *--------------------------------------------------------------------------------
 *| Функция            | Назначение                                              |
 *| ------------------ | ------------------------------------------------------- |
 *| `normalizeRange`   | Нормализует число или HEX в диапазон                    |
 *| `dimmerTime`       | Корректирует время с учётом смещения                    |
 *| `autoOff`          | Таймер автоотключения лампы                             |
 *| `initDefaults`     | Устанавливает свойства объекта по умолчанию             |
 *| `getAutoLevelCct`  | Получает текущие значения яркости и CCT для авто режима |
 *| `adjustProperty`   | Универсальное изменение свойства (яркость/температура)  |
 *| `createObjectMenu` | Создает меню управления объектом рекурсивно             |
 *--------------------------------------------------------------------------------
 */


/** Проверяет и нормализует значение: числовое или HEX (цвет/яркость).
 * normalizeRange($val, $min, $max) 
 * @param mixed $val  Входное значение (число или HEX)
 * @param int $min    Минимальное значение диапазона
 * @param int $max    Максимальное значение диапазона
 * @return int|string|null Возвращает нормализованное число или HEX, либо null если невалидно
 */
 if (!function_exists('normalizeRange')) {
	function normalizeRange($val, $min = 0, $max = 100) {
		$val = strtolower(trim($val));
		if (preg_match('/^[0-9a-f]{12}$/i', $val)) {
			return $val;
		} elseif (preg_match('/^#?[0-9a-f]{6}$/i', $val)) {
			return $val;
		} elseif (is_numeric($val)) {
			return (int)max($min, min($max, $val));
		} else {
			return null;
		}
	}
}

/** Вычисляет новое время с поправкой.
 * dimmerTime($time, $addTime, $sign) 
 * @param string $time Исходное время HH:MM
 * @param string $addTime Коррекция HH:MM
 * @param int $sign 1=прибавить, 0=вычесть
 * @return string Скорректированное время HH:MM
 */
if (!function_exists('dimmerTime')) {
	function dimmerTime($time, $addTime, $sign=1) {
		$modifier = ($sign?'+':'-') . str_replace(':',' hours ',$addTime) . ' minutes';
		return date('H:i', strtotime("$time $modifier"));
	}
}

/** Запускает таймер автоотключения лампы.
 * autoOff($object, $timer, $flag, $presence)
 * @param object|string $object Объект лампы или его имя
 * @param string|int $timer Свойство таймера или конкретное число (сек)
 * @param string|int $flag Флаг блокировки авто режима
 * @param string|int $presence Свойство датчика присутствия
 */
if (!function_exists('autoOff')) {
	function autoOff($object, $timer='timerOff', $flag='flag', $presence='presence') {
		$object = is_object($object)?$object:(is_string($object)?getObject($object):null);
		if(!$object) return;

		$name = $object->object_title;
		$timerValue=120; $flagValue=0; $presenceValue=0;

		if(is_string($timer)) $timerValue=(int)($object->getProperty($timer)??120);
		elseif(is_numeric($timer)) $timerValue=(int)$timer;

		if(is_string($flag)) $flagValue=$object->getProperty($flag)??0;
		elseif(is_numeric($flag)) $flagValue=$flag;

		if(is_string($presence)) $presenceValue=$object->getProperty($presence)??0;
		elseif(is_numeric($presence)) $presenceValue=$presence;

		if($timerValue===0) return;
		$timerCode = "if(!getGlobal('{$name}.{$flag}') && !getGlobal('{$name}.{$presence}')) callMethod('{$name}.turnOff');";
		setTimeOut($name.'Timer', $timerCode, $timerValue);
	}
}

/** Инициализирует свойства объекта по умолчанию
 * initDefaults($object, $defaults)
 * @param object $object Объект лампы
 * @param array $defaults Массив ['свойство'=>'значение']
 */
if (!function_exists('initDefaults')) {
	function initDefaults($object, $defaults) {
		foreach($defaults as $prop=>$val) {
			if($object->getProperty($prop)==='') $object->setProperty($prop,$val);
		}
	}
}

/** Получает актуальные значения яркости и CCT для авто режима
 * getAutoLevelCct($object, $level, $cct)
 * @param object $object Объект лампы
 * @param int|null $level Значение яркости, если задано
 * @param int|null $cct Значение CCT, если задано
 * @return array ['level'=>int, 'cct'=>int]
 */
if (!function_exists('getAutoLevelCct')) {
	function getAutoLevelCct($object, $level=null, $cct=null) {
		$dayBegin=$object->getProperty('dayBegin');
		$nightBegin=$object->getProperty('nightBegin');

		if($object->getProperty('workingBy')==2 &&
		   $object->getProperty('sunriseTime')!=$object->getProperty('sunsetTime')) {
			$dayBegin=dimmerTime($object->getProperty('sunriseTime'),$object->getProperty('addTimeSunrise'),$object->getProperty('signSunrise'));
			$nightBegin=dimmerTime($object->getProperty('sunsetTime'),$object->getProperty('addTimeSunset'),$object->getProperty('signSunset'));
		}

		$currentLevel = null;
		$currentCct = null;

		if($object->getProperty('workingBy')!=3) {
			if(($object->getProperty('workingDay')==2 || $object->getProperty('workingDay')==3) && timeBetween($nightBegin,$dayBegin)) {
				$currentLevel=$level ?? $object->getProperty('nightLevel');
				$currentCct=$cct ?? $object->getProperty('nightCct');
			} elseif(($object->getProperty('workingDay')==1 || $object->getProperty('workingDay')==3) && timeBetween($dayBegin,$nightBegin)) {
				$currentLevel=$level ?? $object->getProperty('dayLevel');
				$currentCct=$cct ?? $object->getProperty('dayCct');
			}
		} elseif($object->getProperty('workingBy')==3 && $object->getProperty('illuminance')<=$object->getProperty('illuminanceMax')) {
			$currentLevel=$level ?? $object->getProperty('nightLevel');
			$currentCct=$cct ?? $object->getProperty('nightCct');
			$object->setProperty('illuminanceFlag',1);
		}

		return ['level'=>$currentLevel,'cct'=>$currentCct];
	}
}

/** Универсальное изменение свойств (яркость, температура и т.п.)
 * adjustProperty($obj, $property, $value ?? null, $direction, $defaultStep, $min, $max);
 * @param object $obj — объект (обычно $this)
 * @param string $property — имя свойства ('level', 'cct' и т.п.)
 * @param mixed $value — шаг изменения (число или null)
 * @param string $direction — 'up' или 'down'
 * @param int $defaultStep — шаг по умолчанию (если не задан) = 10
 * @param int $min — минимальное значение (если не задан) = 0
 * @param int $max — максимальное значение (если не задан) = 100
 */
if (!function_exists('adjustProperty')) {
	function adjustProperty($obj, $property, $value = null, $direction = 'up', $defaultStep = 10, $min = 0, $max = 100)
    {
        $current = (int)$obj->getProperty($property);

        // Определяем шаг изменения
        $step = is_numeric($value) ? (int)$value : $defaultStep;
        $step = max(1, min($max, abs($step)));

        // Изменяем значение в нужную сторону
        $newValue = ($direction === 'up')
            ? min($max, $current + $step)
            : max($min, $current - $step);

        // Применяем новое значение
        $obj->callMethod("set" . ucfirst($property), ['value' => $newValue]);
    }
}

/** Создает меню для объекта рекурсивно.
 * createObjectMenu($objectName, $menuItems);
 * @param string $objectName Имя объекта, к которому привязываются команды.
 * @param array $menuItems Массив элементов меню. Каждый элемент должен быть массивом:
 * 	Формат пункта массива $menuItems= [[$objectName, '', '', '', '', '', '', '', '', '', '', '', [],'']];
 * 
 * 	[
 * 		 0 => 'TITLE',          // Название команды
 * 		 1 => 'LINKED_OBJECT',  // Связанный объект (если пусто, используется $objectName)
 * 		 2 => 'LINKED_PROPERTY',// Свойство объекта
 * 		 3 => 'TYPE',           // Тип команды
 * 		 4 => 'CUR_VALUE',      // Текущее значение
 * 		 5 => 'MIN_VALUE',      // Минимальное значение
 * 		 6 => 'MAX_VALUE',      // Максимальное значение
 * 		 7 => 'STEP_VALUE',     // Шаг изменения
 *  	 8 => 'READ_ONLY',      // Только чтение (0 или 1)
 *  	 9 => 'CODE',           // Произвольный код
 *  	 10 => 'DATA',          // Дополнительные данные
 * 		 11 => 'PRIORITY',      // Приоритет команды
 *  	 12 => [ подменю ],     // Массив подменю (необязательный)
 *  	 13 => 'ICON',          // Иконка
 * 	]
 * 
 * @param int $parentId ID родительской команды. По умолчанию 0 (корень).
 * @param int $insertID Текущий последний ID команд. Используется для рекурсивной вставки.
 * @param int $depth Глубина рекурсии. Используется для определения, когда получать MAX(ID).
 *
 * @return int Возвращает последний использованный ID после вставки всех команд.
 */
if (!function_exists('createObjectMenu')) {
	function createObjectMenu($objectName, $menuItems, $parentId = 0, $insertID = 0, $depth = 0){
		// при первом вызове получаем максимальный ID из таблицы
		if ($depth === 0 && $insertID === 0) {
			$data = SQLSelectOne("SELECT MAX(ID) AS MAX_ID FROM commands");
			$insertID = $data['MAX_ID'] ?? 0;
		}

		foreach ($menuItems as $item) {

			$Record = [];
			$Record['ID'] = ++$insertID;
			$Record['PARENT_ID'] = $parentId;
			$Record['PARENT_LIST'] = ($parentId == 0) ? '0' : $parentId;
			
			// параметры
			$Record['TITLE'] = $item[0] ?? '';
			$Record['LINKED_OBJECT'] = $item[1] ?: $objectName;
			$Record['LINKED_PROPERTY'] = $item[2] ?? '';
			$Record['TYPE'] = $item[3] ?? '';
			$Record['CUR_VALUE'] = $item[4] ?? 0;
			$Record['MIN_VALUE'] = $item[5] ?? 0;
			$Record['MAX_VALUE'] = $item[6] ?? 0;
			$Record['STEP_VALUE'] = $item[7] ?? 0;
			$Record['READ_ONLY'] = $item[8] ?? 0;
			$Record['CODE'] = $item[9] ?? NULL;
			$Record['DATA'] = $item[10] ?? NULL;
			$Record['PRIORITY'] = $item[11] ?? 10;
			$Record['SUB_PRELOAD'] = isset($item[12]) ? 1 : 0;
			$Record['ICON'] = $item[13] ?? '';

			// добавляем команду
			SQLInsert('commands', $Record);

			// если есть подменю — рекурсия
			if (!empty($item[12]) && is_array($item[12])) {
				$firstChildId = $insertID + 1;
				$insertID = createObjectMenu($objectName, $item[12], $Record['ID'], $insertID, $depth + 1);
				$lastChildId = $insertID;

				// обновляем SUB_LIST у родителя
				$childIds = range($firstChildId, $lastChildId);
				$subList = implode(',', $childIds);
				SQLExec("UPDATE commands SET SUB_LIST = '" . DBSafe($subList) . "' WHERE ID = '" . (int)$Record['ID'] . "'");
			}
		}

		return $insertID;
	}
}