<?php

namespace App\Utils;

class WeekDays
{
    public static function days()
    {
        return [
            'monday' => 'Thứ hai',
            'tuesday' => 'Thứ ba',
            'wednesday' => 'Thứ tư',
            'thursday' => 'Thứ năm',
            'friday' => 'Thứ sáu',
            'saturday' => 'Thứ bảy',
            'sunday' => 'Chủ nhật',
        ];
    }

    public static function trans($day)
    {
        switch ($day) {
            case "monday":
                return "Thứ hai";
            case "tuesday":
                return "Thứ ba";
            case "wednesday":
                return "Thứ tư";
            case "thursday":
                return "Thứ năm";
            case "friday":
                return "Thứ sáu";
            case "saturday":
                return "Thứ bảy";
            case "sunday":
                return "Chủ nhật";
        }
    }
}
