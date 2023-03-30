<?php

namespace App\Utils;

class Roles
{
    public static array $entries = [
        "basket" => 'danh mục sách',
        "bonus" => 'bù ngày',
        "book" => 'sách',
        "document" => 'tài liệu',
        "extend" => 'hóa đơn gia hạn',
        "grade" => 'lớp',
        'invoice' => 'hóa đơn thu khác',
        'logs' => 'nhật ký',
        'old' => 'học sinh cũ',
        'pack' => 'gói mặc định',
        'payment' => 'hóa đơn chi',
        'student' => 'học sinh đang học',
        'user' => 'người dùng',
        'work' => 'nhật ký làm việc',
        'branch' => 'chi nhánh',
        'reserve' => 'học sinh bảo lưu',
    ];
    public static array $methods = [
        'list' => 'Xem',
        'create' => 'Thêm',
        'update' => 'Sửa',
    ];

    public static function default()
    {
        $result = [];
        foreach (self::$entries as $entry_key => $entry) {
            if ($entry_key != "user") {
                foreach (self::$methods as $method_key => $method) {
                    $result[] = $entry_key . "." . $method_key;
                }
            }
            if ($entry_key != "branch") {
                foreach (self::$methods as $method_key => $method) {
                    $result[] = $entry_key . "." . $method_key;
                }
            }
        }
        return \array_diff($result);

    }

    public static function getAllRoles(): array
    {
        $result = [];
        foreach (self::$entries as $entry_key => $entry) {
            foreach (self::$methods as $method_key => $method) {
                $result[$entry_key . "." . $method_key] = $method . " " . $entry;
            }
        }
        $result['finance'] = "Báo cáo tài chính";
        return $result;
    }
}
