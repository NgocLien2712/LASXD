<?php
$h = password_hash('123456', PASSWORD_DEFAULT);
echo $h . "\n";
echo password_verify('123456', $h) ? "ok" : "bad";
