<?php

class MainHelper
{

    public static function initCalendar($canAssign = false)
    {
        $calendarItems = [];

        $calendarStart = strtotime('01/01/' . (date('Y') - 5));
        $calendarFinish = strtotime('12/31/' . (date('Y') + 5));

        for ($i = $calendarStart; $i < $calendarFinish; $i += 86400) {
            list($year, $month, $day) = explode("|", date("Y|m|d", $i));
            $calendar[] = $year . '-' . $month . '-' . $day;
        }

        foreach (array_reverse($calendar) as $date) {
            $calendarModel = Calendar::model()->findAllByAttributes(array('data' => $date));

            if ($canAssign) {
                if ($calendarModel) {
                    $calendarItems[$date] = array(
                        'id' => 'activedate',
                        'data-date' => $date,
                        'title' => 'Призначити',
                        'style' => 'font-weight: bold; width: 25px;',
                        'class' => 'btn btn-warning',
                        'href' => '#',
                        'data-toggle' => 'modal',
                        'data-target' => '#myModal',
                    );
                } else {
                    $calendarItems[$date] = array(
                        'id' => 'activedate',
                        'data-date' => $date,
                        'title' => 'Призначити',
                        'style' => 'font-weight: bold; color: #fffff;',
                        'href' => '#',
                        'data-toggle' => 'modal',
                        'data-target' => '#myModal',
                    );
                }
            } else {
                $calendarItems[$date] = array(
                    'id' => 'activedate',
                    'data-date' => $date,
                    'title' => 'Призначити',
                    'style' => !empty($calendarModel) ? 'font-weight: bold; width: 25px;' : 'font-weight: bold; color: #fffff;',
                    'class' => !empty($calendarModel) ? 'btn btn-warning' : '',
                );
            }
        }

        return $calendarItems;
    }

    public static function generateConfirmCode($number)
    {

        $arr = array('1', '2', '3', '4', '5', '6', '7', '8', '9', '0');
        $code = "";
        for ($i = 0; $i < $number; $i++) {
            $index = rand(0, count($arr) - 1);
            $code .= $arr[$index];
        }
        return $code;
    }

    public static function generatePassword($number)
    {
        $arr = array('a', 'b', 'c', 'd', 'e', 'f',
            'g', 'h', 'i', 'j', 'k', 'l',
            'm', 'n', 'o', 'p', 'r', 's',
            't', 'u', 'v', 'x', 'y', 'z',
            'A', 'B', 'C', 'D', 'E', 'F',
            'G', 'H', 'I', 'J', 'K', 'L',
            'M', 'N', 'O', 'P', 'R', 'S',
            'T', 'U', 'V', 'X', 'Y', 'Z',
            '1', '2', '3', '4', '5', '6',
            '7', '8', '9', '0', '.', ',',
            '(', ')', '[', ']', '!', '?',
            '&', '^', '%', '@', '*', '$',
            '<', '>', '/', '|', '+', '-',
            '{', '}', '`', '~');
        $pass = "";
        for ($i = 0; $i < $number; $i++) {
            $index = rand(0, count($arr) - 1);
            $pass .= $arr[$index];
        }
        return $pass;
    }


    public static function translit($str)
    {
        $translit = array(
            'А' => 'a', 'Б' => 'b', 'В' => 'v', 'Г' => 'g', 'Д' => 'd', 'Е' => 'e', 'Ё' => 'yo', 'Ж' => 'zh', 'З' => 'z',
            'И' => 'i', 'Й' => 'i', 'К' => 'k', 'Л' => 'l', 'М' => 'm', 'Н' => 'n', 'О' => 'o', 'П' => 'p', 'Р' => 'r',
            'С' => 's', 'Т' => 't', 'У' => 'u', 'Ф' => 'f', 'Х' => 'h', 'Ц' => 'ts', 'Ч' => 'ch', 'Ш' => 'sh', 'Щ' => 'sch',
            'Ъ' => '', 'Ы' => 'y', 'Ь' => '', 'Э' => 'e', 'Ю' => 'yu', 'Я' => 'ya',
            'а' => 'a', 'б' => 'b', 'в' => 'v', 'г' => 'g', 'д' => 'd', 'е' => 'e', 'ё' => 'yo', 'ж' => 'zh', 'з' => 'z',
            'и' => 'i', 'й' => 'i', 'к' => 'k', 'л' => 'l', 'м' => 'm', 'н' => 'n', 'о' => 'o', 'п' => 'p', 'р' => 'r',
            'с' => 's', 'т' => 't', 'у' => 'u', 'ф' => 'f', 'х' => 'h', 'ц' => 'ts', 'ч' => 'ch', 'ш' => 'sh', 'щ' => 'sch',
            'ъ' => '', 'ы' => 'y', 'ь' => '', 'э' => 'e', 'ю' => 'yu', 'я' => 'ya',
            ' ' => '-', '!' => '', '?' => '', '(' => '', ')' => '', '#' => '', ',' => '', '№' => '', ' - ' => '-', '/' => '-', '  ' => '-',
            'A' => 'a', 'B' => 'b', 'C' => 'c', 'D' => 'd', 'E' => 'e', 'F' => 'f', 'G' => 'g', 'H' => 'h', 'I' => 'i', 'J' => 'j', 'K' => 'k', 'L' => 'l', 'M' => 'm', 'N' => 'n',
            'O' => 'o', 'P' => 'p', 'Q' => 'q', 'R' => 'r', 'S' => 's', 'T' => 't', 'U' => 'u', 'V' => 'v', 'W' => 'w', 'X' => 'x', 'Y' => 'y', 'Z' => 'z',
            '"' => '', '\'' => ''
        );
        return strtr($str, $translit);
    }

    public static function setNumberFormat($number)
    {
        return str_replace(',', '.', $number);
    }
}