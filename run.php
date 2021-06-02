<?php

require_once('src/func.php');
require_once('src/Lambda.php');

$add = lambda(fn($a, $b) => $a + $b);

$array = [
    ['num' => 1],
    ['num' => 2],
    ['num' => 3],
    ['num' => 4],
];

$add2 = $add(2);
$pluck = Lambda::pluck('num');
$map = Lambda::map($add2);
$sum = Lambda::map($add2);
printr($map($pluck($array)));

$calls = [
    Lambda::pluck('num'),
    Lambda::map($add2),
    Lambda::sum(),
];

$ret = $array;

foreach($calls as $call)
{
    $ret = $call($ret);
}

printr($ret);

$len = Lambda::curry('strlen');

printr($len('aaaaa1'));

$ret =
    Lambda::compose(
        Lambda::pluck('num'),
        Lambda::map($add2),
        Lambda::sum(),
    )
    ($array)
;

printr($ret);
