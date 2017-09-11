<?php
/**
 * Created by PhpStorm.
 * User: haobin
 * Date: 2017/9/10
 * Time: 20:48
 */
class Test {
    public function __construct()
    {
        echo "i am ".get_class();
    }
}
$a = 0;
$b = 0;
if($a=3 > 0 || $b =3 > 0) {
    $a++;
    $b++;
    echo $a.'\n';
    echo $b.'\n';
}