<?php

function test001() {
    yield 1;
}

$a = test001();

var_dump($a);
$result = $a->current();
