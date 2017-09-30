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
$outer = 'ster';
function test() {
    global  $outer;
    echo $outer;
}

$count = 5;
function echo_count(){
    static  $count;
    return $count++;
}
echo $count;
echo "<br>";
++$count;
echo echo_count();
echo "<br>";
echo echo_count();