<?php

$str = "中文";

for ($i=0; $i<strlen($str); $i++) {
    echo dechex(ord($str[$i])) . "\n";
}
