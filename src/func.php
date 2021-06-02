<?php

function printr($data)
{
    $data = print_r($data, true);
    echo $data.PHP_EOL;
}
