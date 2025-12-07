<?php

/**
 * Создание или удаление меню управления устройством в системе MajorDoMo.
 *
 * Скрипт формирует структуру меню для объекта лампы и может:
 *   - создать все команды меню в таблице commands (через createCommandsMenu)
 *   - удалить эти команды, если передано значение delete (через deleteCommandsMenu)
 *
 * Структура меню включает:
 *   - Главную группу с базовыми параметрами (Вкл/Выкл, Яркость, Температура)
 *   - Автовключение: переключатель, задержка, рабочий диапазон и источник триггера
 *   - Настройки по солнцу: восход, закат и возможность смещения времени
 *   - Настройки датчика освещённости
 *   - Настройки начала дня и ночи по времени
 *   - Параметры цвета: дневные и ночные значения яркости и температуры, минимальные и максимальные ограничения
 *
 * Структура массива $menuItems полностью соответствует формату
 * команд и подкоманд MajorDoMo, используемому функцией createCommandsMenu().
 *
 * Поведение:
 *   - Если параметр $deleteMenu равен 'delete', вызывается deleteCommandsMenu()
 *     и все пункты меню, соответствующие структуре, удаляются.
 *   - Иначе вызывается createCommandsMenu() и пункты меню создаются в БД.
 *
 * @param string $objectName   Название объекта (обычно $this->object_title),
 *                             используется как базовое имя в меню и как LINKED_OBJECT.
 * @param string|null $deleteMenu Значение параметра действия. Если 'delete' —
 *                                меню удаляется, иначе создаётся.
 * @param array $menuItems     Массив структуры меню в формате MajorDoMo:
 *                             [TITLE, LINKED_OBJECT, LINKED_PROPERTY, TYPE, ... , SUBMENU[]].
 *
 * @return void
 */

$objectName = $this->object_title;
$deleteMenu = $params['value'] ?? null;

$menuItems = [
    // Главное меню
    [$objectName, $objectName, '', '', '', '', '', '', '', '', '', 10, [
        ['Вкл/Выкл', $objectName, 'status', 'switch', '', '', '', '', '', "if (\$new_value) {callMethod('{$objectName}.turnOn');}else{callMethod('{$objectName}.turnOff');}", '', 80],
        ['Яркость', $objectName, 'level', 'sliderbox', '', 0, 100, 1, '', '', '', 70],
        ['Температура', $objectName, 'cct', 'sliderbox', '', 0, 100, 1, '', '', '', 60],

        // Автовключение
        ['Автовключение', $objectName, '', '', '', '', '', '', '', '', '', 50, [
            ['Вкл/Выкл', $objectName, 'autoOnOff', 'switch', '', '', '', '', '', '', '', 40],
            ['Задержка(сек)', $objectName, 'timerOff', 'plusminus', '', 0, 10000, 5, '', '', '', 30],
            ['Включать', $objectName, 'workingDay', 'selectbox', '', '', '', '', '', '', "1=День\r\n2=Ночь\r\n3=24 часа", 20],
            ['Работать по', $objectName, 'workingBy', 'selectbox', '', '', '', '', '', '', "1=Время\r\n2=Солнце\r\n3=Датчик", 10],
        ]],

        // Солнце
        ['Солнце', $objectName, '', '', '', '', '', '', '', '', '', 40, [
            ['Восход', $objectName, 'addTimeSunrise', 'timebox', '', -21600, 21600, 60, '', '', '', 40],
            ['Прибавить/Отнять', $objectName, 'signSunrise', 'selectbox', '', '', '', '', '', '', "1=Прибавить\r\n0=Отнять", 30],
            ['Закат', $objectName, 'addTimeSunset', 'timebox', '', -21600, 21600, 60, '', '', '', 20],
            ['Прибавить/Отнять', $objectName, 'signSunset', 'selectbox', '', '', '', '', '', '', "1=Прибавить\r\n0=Отнять", 10],
        ]],

        // Датчик
        ['Датчик', $objectName, '', '', '', '', '', '', '', '', '', 30, [
            ['Макс.Освещение', $objectName, 'illuminanceMax', 'plusminus', '', 0, 500, 1, '', '', '', 10],
        ]],

        // Время
        ['Время', $objectName, '', '', '', '', '', '', '', '', '', 20, [
            ['Начало Ночь', $objectName, 'nightBegin', 'timebox', '', -21600, 21600, 60, '', '', '', 20],
            ['Начало День', $objectName, 'dayBegin', 'timebox', '', -21600, 21600, 60, '', '', '', 10],
        ]],

        // Цвет
        ['Цвет', $objectName, '', '', '', '', '', '', '', '', '', 10, [
            ['Яркость', '', '', '', '', '', '', '', '', '', '', 20, [
                ['Днем', $objectName, 'dayLevel', 'sliderbox', '', 0, 100, 1, '', '', '', 40],
                ['Ночью', $objectName, 'nightLevel', 'sliderbox', '', 0, 100, 1, '', '', '', 30],
                ['Максимальная', $objectName, 'levelMaxWork', 'sliderbox', '', 0, 1000, 1, '', '', '', 20],
                ['Минимальная', $objectName, 'levelMinWork', 'sliderbox', '', 0, 1000, 1, '', '', '', 10],
            ]],
            ['Температура', $objectName, '', '', '', '', '', '', '', '', '', 10, [
                ['Днем', $objectName, 'dayCct', 'sliderbox', '', 0, 100, 1, '', '', '', 40],
                ['Ночью', $objectName, 'nightCct', 'sliderbox', '', 0, 100, 1, '', '', '', 30],
                ['Максимальная', $objectName, 'cctMaxWork', 'sliderbox', '', 1, 1000, 1, '', '', '', 20],
                ['Минимальная', $objectName, 'cctMinWork', 'sliderbox', '', 1, 1000, 1, '', '', '', 10],
            ]],
        ]],
    ],'SDimmersCctLightLamp2.png']
];

if($deleteMenu === 'delete'){
    deleteCommandsMenu($objectName, $menuItems);
}else{
    createCommandsMenu($objectName, $menuItems);
}
