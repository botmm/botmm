<?php

$size   = 1;
$buffer = new swoole_buffer($size);

for ($i = 0; $i < 1024 * 1024 * 20; $i++) {
    if ($i >= $size) {
        $size <<= 1;
        $buffer->expand($size);
        echo $size . "\n";
    }
    $buffer->write($i, 'a');
}

