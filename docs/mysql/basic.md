##MySQL基本操作

### 一、常用命令
- veresion();    //显示当前服务版本
- now();     //显示当前时间
- user();    //显示当前用户
- concat('a', 'b');     //字符链接
- concat_ws('-', 'a', 'b'); //使用指定分隔符连接
- lower('MYSQL') upper('mysql') //大小写转换
- left('mysql', 2)  //左截取 right('mysql', 2) //右截取
- length('mysql')   //获取字符串长度
- replace('-my-sql', '-', '+')  //替换字符
- substring('mysql', 1 ,2)  //截取字符
- date_format('2017-9-11', '%Y-%m-%d'); //日期格式化
- avg();    //平均值
- count();  //总数
- max(); min()   //最大值，最小值
- sum();    //求和

### 二、常用数据库操作
1.创建数据库
```
create {database|schema} [if not exists] db_name [default] character set [=] charset_name
例：CREATE DATABASE test;
```
2.修改数据库
``` 
alter {database|schema} db_name [default] character set [=] charset_name
例：ALTER DATABASE test CHARACTER SET utf8;
```
4.删除数据库
``` 
drop {database|schema} [if exists] db_name
例：DROP DATABASE test;
```

###三、常用数据表操作
1.创建表
``` 
create table [if not exists] tbl_name(
    age tinyint(2) unsigned not null auto_increment primary key
);
例：CREATE TABLE user(
    id INT(10) UNSIGNED AUTO_INCREMENT PRIMARY KEY,//主键自增
    name VARCHAR(20) NOT NULL UNIQUE KEY,//唯一
    price DECIMAL(8,2) UNSIGNED DEFAULT 0.00,//默认
    cid INT(10) UNSIGNED,
    KEY cid(cid),
    FOREIGN KEY (cid) REFERENCES cate (id) ON DELETE CASCADE//外键 （删除时执行CASCADE）
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
```
2.查看表结构
``` 
show colums from tbl_name;
例：SHOW COLUMUNS FROM user
```
3. 修改表结构
``` 
alter table tbl_name op[add|drop|modify] [column] (col_name column_definition,..);
例：
ALTER TABLE user ADD num INT(10) UNSIGNED, time INT(10) UNSIGNED;  // 添加字段
ALTER TABLE user DROP num,DROP time;    // 删除字段
```
4.插入
``` 
（1）insert [into] tbl_name [(col_name,..)] {values|value} ({expr|default},...),(...),...;
例：INSERT user (id,name,price) VALUES (DEFAULT,tom',20);
```
5.更新
``` 
update tbl_name set col_name1={expr1|default} [,col_name2={expr2|default}].. [where where_condition]
例：UPDATE user SET num = num + id;
```
6.删除
``` 
delete from tbl_name [where where_condition]
例：DELETE FROM user WHERE id=3;
```

###四、约束性
(1)主键约束：primary key
1. 每个表只存在一个
2. 保证记录的唯一性
3. 自动为not null
4. 添加了主键约束
(2)唯一约束： unique key
1. 每个表可以存在多个
2. 保证记录的唯一性
3. 可以存一个null
4. 添加了唯一约束
(3)默认约束：default
1. 给列添加了默认值
``` 
例如：
ALTER TABLE user ALTER num SET DEFAULT 0;
ALTER TABLE user ALTER num DROP DEFAULT;
```