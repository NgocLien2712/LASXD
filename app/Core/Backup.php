<?php
namespace App\Core;

class Backup {
    public static function run() {
        $host = $_ENV['DB_HOST'];
        $db   = $_ENV['DB_NAME'];
        $user = $_ENV['DB_USER'];
        $pass = $_ENV['DB_PASS'];
        
        $fileName = "backup_" . date("Y-m-d_H-i-s") . ".sql";
        $filePath = __DIR__ . "/../../backup/" . $fileName;

        // Lệnh thực thi mysqldump (Đảm bảo máy bạn đã cài MySQL)
        $command = "mysqldump -h $host -u $user ".($pass ? "-p$pass" : "")." $db > $filePath";
        
        system($command, $output);
        return $fileName;
    }
}