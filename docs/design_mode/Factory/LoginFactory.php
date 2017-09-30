<?php
/**
 * Created by PhpStorm.
 * User: haobin
 * Date: 2017/9/30
 * Time: 17:39
 */


require_once './DomainLogin.php';
require_once './PasswordLogin.php';

/**
 * Class LoginFactory
 * 工厂模式
 * 通过不同的参数来返回不同的对象实例
 * 被返回的实例通常是同一功能的不同实现
 */
class LoginFactory {
    
    public static function getLoginFactory($type) {
        if($type == 'domain') {
            return new DomainLogin();
        }else if($type == 'pass') {
            return new PasswordLogin();
        }else {
            throw new Exception('class not found');
        }
    }
}