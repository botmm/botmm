<?php

$size   = 1;
$buffer = new swoole_buffer($size);

$move = 0;
for ($i = 0; $i < 1024 * 1024 * 20; $i++) {
    if ($i >= $size) {
        $size += 1;
        $buffer->expand($size);
    }
    $buffer->write($i, 'a');

    if($size >> $move){
        echo $size . "\n";
        $move++;
    }
}
