<?php
/**
 * Created by PhpStorm.
 * User: haobin
 * Date: 2017/9/10
 * Time: 20:45
 */
function __autoload($className) {
    $file = __DIR__.'/'.$className. '.php';
    if (file_exists($file)) {
        require $file;
    }
}
$demo = new Test();
