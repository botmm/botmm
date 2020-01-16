<?php


try {
    $objNum = 200;
    $count  = 1024 * 1024;
    do {
        $fd = fopen('php://memory', 'wb');
        do {
            fwrite($fd, 'a');
        } while ($count--);
        fclose($fd);
    } while ($objNum--);
} catch (Exception $e) {
    print_r(filesize($fd));
}