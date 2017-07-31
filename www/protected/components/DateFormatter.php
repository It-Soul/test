<?php
/**
 * Created by Taras Holyk
 * Date: 19.12.2016
 * Time: 21:18
 */
class DateFormatter
{
    public static function formatDateForSqlFilter($date, $withQuotes = false)
    {
        if ($withQuotes) {
            return '"' . date('Y-m-d', strtotime(str_replace('.', '-', $date))) . '"';
        }
        return date('Y-m-d', strtotime(str_replace('.', '-', $date)));
    }

}