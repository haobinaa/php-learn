<?php
/**
 * Created by PhpStorm.
 * User: haobin
 * Date: 2017/9/13
 * Time: 23:29
 */
$dirPath = "./test_dir";

function loopDir($dirPath) {
    $handle = opendir($dirPath);
    // 此处用全等于，如果目录名称为0返回也是false所以要类型也相等
    while(false !== ($file = readdir($handle))) {
        if($file != '.' && $file != '..') {
            echo $file."<br>";
            if(is_dir($dirPath.'/'.$file)) {
                loopDir($dirPath.'/'.$file);
            }
        }
    }
}
loopDir($dirPath);