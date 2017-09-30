<?php
/**
 * Created by PhpStorm.
 * User: haobin
 * Date: 2017/9/13
 * Time: 22:45
 */
function &myFunc(){
    static $b = 10;
    return $b;
}
$a = myFunc();
$a = &myFunc();
$a = 100;
echo myFunc();