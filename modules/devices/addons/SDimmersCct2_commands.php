<?php

if ($device_type == 'SDimmersCct2') {

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
