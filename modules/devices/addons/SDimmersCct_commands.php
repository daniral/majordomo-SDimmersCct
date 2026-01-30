<?php
/**
 * Обрабатывает голосовые команды для устройства типа SDimmersCct.
 *
 * Поддерживаемые функции:
 *
 * 1. Управление питанием:
 *    - Включение устройства (команды, соответствующие LANG_DEVICES_PATTERN_TURNON)
 *    - Выключение устройства (LANG_DEVICES_PATTERN_TURNOFF)
 *    - Переключение состояния (LANG_DEVICES_PATTERN_SWITCH)
 *
 * 2. Управление яркостью:
 *    2.1. Абсолютные значения:
 *         - Команды вида: "яркость 70%", "сделай на 30", "выставь 100%"
 *         - Определяются по числовому значению (1–100%)
 *
 *    2.2. Увеличение яркости:
 *         - Ключевые слова: "ярче", "увеличь", "прибавь", "добавь", "больше", "поярче"
 *         - Изменяет уровень на +10
 *
 *    2.3. Уменьшение яркости:
 *         - Ключевые слова: "тусклее", "меньше", "приглуши", "потемнее"
 *         - Изменяет уровень на -10
 *
 * 3. Управление цветовой температурой (CCT):
 *    3.1. Абсолютные значения:
 *         - Команды вида: "теплота 80%", "холодность 20%" и т.п.
 *
 *    3.2. Предустановленные стили:
 *         - "самый холодный"                      → 0
 *         - "максимально холодный"                → 0
 *         - "холодный"                            → 25
 *         - "прохладный"                          → 33
 *         - "нейтральный"                         → 50
 *         - "тёплый", "теплый"                    → 75               
 *         - "максимально тёплый", "самый тёплый"  → 100
 *
 *    3.3. Относительное изменение CCT:
 *         - Нагрев (теплее):   "теплее", "жёлтее", "желтее" → +10
 *         - Охлаждение:        "прохладнее", "холоднее", "синее" → -10
 *
 * Результат обработки:
 *    - Формирует $run_code — действие при срабатывании
 *    - Формирует $opposite_code — действие отмены
 *    - Устанавливает $processed = 1 если команда была распознана
 *    - Может включать подтверждающий ответ ($reply_confirm = 1)
 *
 * Параметры, которые должны быть доступны извне:
 *    @param string $device_type     Тип устройства (ожидается 'SDimmersCct')
 *    @param string $command         Текст голосовой команды
 *    @param string $linked_object   Имя объекта устройства
 *    @param string $device_title    Человекочитаемое имя устройства
 *    @param string $add_phrase      Дополнительная фраза для TTS ("в комнате", "над столом")
 *
 * Используемые глобальные переменные:
 *    @var string $run_code          Код выполнения
 *    @var string $opposite_code     Код обратного действия
 *    @var int    $processed         Флаг успешного распознавания
 *    @var int    $reply_confirm     Флаг подтверждения ответа
 *
 * @return void
 */

if ($device_type == 'SDimmersCct') {

    // --- ВКЛ / ВЫКЛ / ПЕРЕКЛЮЧИТЬ ---
    if (preg_match('/' . LANG_DEVICES_PATTERN_TURNON . '/uis', $command)) {
        sayReplySafe(LANG_TURNING_ON . ' ' . $device_title . $add_phrase, 2);
        $run_code      .= "callMethod('$linked_object.turnOn');";
        $opposite_code .= "callMethod('$linked_object.turnOff');";
        $processed = 1;
    }

    elseif (preg_match('/' . LANG_DEVICES_PATTERN_TURNOFF . '/uis', $command)) {
        sayReplySafe(LANG_TURNING_OFF . ' ' . $device_title . $add_phrase, 2);
        $run_code      .= "callMethod('$linked_object.turnOff');";
        $opposite_code .= "callMethod('$linked_object.turnOn');";
        $processed = 1;
    }

    elseif (preg_match('/' . LANG_DEVICES_PATTERN_SWITCH . '/uis', $command)) {
        sayReplySafe(LANG_SWITCH . ' ' . $device_title . $add_phrase, 2);
        $run_code      .= "callMethod('$linked_object.switch');";
        $opposite_code .= "callMethod('$linked_object.switch');";
        $processed = 1;
    }

    // --- ЯРКОСТЬ ---
    elseif (preg_match('/' . LANG_SDimmersCct2_PATTERN_BRIGHTNESS . '/uis', $command)) {
        $currentLevel = (int)getGlobal("$linked_object.level");
        $step = 10;

        // Абсолютные команды: "яркость 70%"
        if (preg_match('/(?:\s)(\d{1,2}|100)(?:%|\s|$)/uis', $command, $matches)) {
            $value = (int)$matches[1];
        }
        // Относительные: "ярче", "приглуши"
        elseif (preg_match('/(ярче|увелич|добав|больше)/uis', $command)) {
            $value = min(100, $currentLevel + $step);
        }
        elseif (preg_match('/(тусклее|меньше|приглуш|потемн)/uis', $command)) {
            $value = max(0, $currentLevel - $step);
        }

        if (isset($value)) {
            $run_code      .= "callMethod('$linked_object.setLevel', array('value' => $value));";
            $opposite_code .= "callMethod('$linked_object.setLevel', array('value' => $value));";
            $processed = 1;
            $reply_confirm = 1;
        }
    }

    // --- ЦВЕТОВАЯ ТЕМПЕРАТУРА ---
    elseif (preg_match('/' . LANG_SDimmersCct2_PATTERN_TEMPERATURE . '/uis', $command)) {
        $currentCct = (int)getGlobal("$linked_object.cct");
        $step = 10;

        // Пресеты для цвета
        $presets = array(
            'самый холодный' => 0,
            'максимально холодный' => 0,
            'холодный' => 25,
            'прохладный' => 33,
            'нейтральный' => 50,
            'тёплый' => 75,
            'теплый' => 75,
            'максимально тёплый' => 100,
            'самый тёплый' => 100,
        );

        // Абсолютные команды: "теплота 80%"
        if (preg_match('/(?:\s)(\d{1,2}|100)(?:%|\s|$)/uis', $command, $matches)) {
            $value = (int)$matches[1];
        }
        // Поиск предустановок
        else {
            foreach ($presets as $word => $presetValue) {
                if (mb_stripos($command, $word) !== false) {
                    $value = $presetValue;
                    break;
                }
            }
        }
        // Относительные команды
        if (!isset($value)) {
            if (preg_match('/(теплее|жёлтее|желтее)/uis', $command)) {
                $value = min(100, $currentCct + $step);
            }
            elseif (preg_match('/(прохладнее|холоднее|синее)/uis', $command)) {
                $value = max(0, $currentCct - $step);
            }
        }

        if (isset($value)) {
            $run_code      .= "callMethod('$linked_object.setCct', array('value' => $value));";
            $opposite_code .= "callMethod('$linked_object.setCct', array('value' => $value));";
            $processed = 1;
            $reply_confirm = 1;
        }
    }
}
