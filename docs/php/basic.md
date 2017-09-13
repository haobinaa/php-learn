# PHP基础知识

### 一、运算符的优先级
- [官方手册](http://php.net/manual/zh/language.operators.precedence.php)
- 递增/递减>！>算数运算符>大小比较>（不）相等比较>引用>位运算符（^ > | > &）> 三目 > 赋值 > and > or
``` 
看一个例子
$a = false || true;
$b = flase or true;
```
结果$a = true,因为||的优先级大于=所以先执行(false || true)

$b=false，因为or的优先级最小，先执行$b=false

``` 
$a = 0;
$b = 0;
if($a=3 > 0 || $b =3 > 0) {
    $a++;
    $b++;
    echo $a.'\n';
    echo $b.'\n';
}
```
结果$a=1,$b=1;因为 > 优先级高于 || 高于 =，所以先执行3>0所以$a=true,直接执行if的代码块

### 二、流程控制
- PHP除了for和foreach之外，还有一种循环的方式list() each() while()
```  
$array = [
    'a' => 'apple',
    'b' => 'banana',
    'c' => 'carrot',
];
// each提取出当前元素的key、value并向前移动数组指针
while(list($key, $value) = each($array)){
    var_dump($key,$value);
    echo "<br>";
}
```
foreach与while-list-each的区别是，foreach遍历前会reset数组指针，而while-list-each则不会。
### 三、作用域以及静态变量
