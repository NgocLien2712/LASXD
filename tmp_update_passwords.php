<?php
$pdo = require __DIR__ . '/db.php';
$hash = '$2y$12$1pSxc8KTjxu0MS/c.lnWleMuwBtCoSjbQ9.5IFYxLQv/e7.v9/k4e';
$count = $pdo->exec("UPDATE nhan_vien SET nv_matkhau = '$hash'");
echo "Updated $count rows\n";
