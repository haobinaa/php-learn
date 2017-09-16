# 垃圾回收机制(garbage collection)

在高级语言中有个很重要的机制叫做垃圾回收(gc)，高级语言不需要手动释放变量，是由语言本身来判断什么时候释放某个变量，而我们需要了解某个变量什么时候被语言释放(回收)了。

 在PHP中没有任何变量指向一个对象时，这个对象就成了垃圾，PHP会将其在内存中销毁，这就是PHP的垃圾回收机制，防止内存溢出

### 一、引用计数
我们知道，PHP变量是存在一个叫zval的变量容器里面，zval有两个变量，一个是`is_ref`来标识这个变量是否属于引用，一个是`refcount`用来统计指向这个变量容器的变量的个数

如下例所示：
``` 
<?php
    $a = "String";
    xdebug_debug_zval('a');
    
#       输出结果
#       a: (refcount=1, is_ref=0)='String'

//  将$a赋给$b
    $b = $a;
    xdebug_debug_zval('a');

#       输出结果
#       a: (refcount=2, is_ref=0)='String'
//  此时我们可以看到refcount的值变为了2，也就是有两个变量指向了这个变量容器
```
当变量不在指向变量容器，或者调用了unset（unset的真实含义并不是删除某个变量，而是让他不再指向某个变量容器）`refcount`的值就会减少
``` 
<?php
    $a = "new string";
    $c = $b = $a;
    xdebug_debug_zval( 'a' );
    unset( $b, $c );
    xdebug_debug_zval( 'a' );
    
#       输出结果
#       a: (refcount=3, is_ref=0)='new string'
#       a: (refcount=1, is_ref=0)='new string
```
上面的例子只是简单的说明了字符串这种简单类型，PHP中array和Object这种复合类型的时候，就会稍微复杂一点