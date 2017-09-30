<?php
/**
 * Created by PhpStorm.
 * User: haobin
 * Date: 2017/9/12
 * Time: 21:29
 */
$array = [
    'a' => 'apple',
    'b' => 'banana',
    'c' => 'carrot',
];
$list = [
    'a' => 'apple',
     0 => 'banana',
    'c' => 'carrot',
    1 => 'tomato',
];
var_dump(each($list));
list($list1, $list2) = each($list);
var_dump($list1, $list2);
echo "<br>";
// each返回当前键值对，分别为0,1，key，value；0和key对应，1和value对应，并向前移动数组指针
//var_dump(each($array));
//print_r(each($array));
//print_r(each($array));
//echo "<br>";
//var_dump(each($array));
while(list($key, $value) = each($array)){
    var_dump($key,$value);
    echo "<br>";
}