<?php
class Helper {
    public static function toLocalTime($utcDate, $timezone = 'Europe/Kiev') {
        if (empty($utcDate)) return '';
        $dt = new DateTime($utcDate, new DateTimeZone('UTC'));
        $dt->setTimezone(new DateTimeZone($timezone));
        return $dt->format('Y-m-d H:i');
    }
}
