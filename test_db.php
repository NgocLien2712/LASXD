<?php
$pdo = require __DIR__ . '/db.php';
echo $pdo->query('SELECT version()')->fetchColumn();