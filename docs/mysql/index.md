#索引
###一、 创建索引
1.普通索引(最基本的索引，无任何限制)

(1)创建索引
``` 
CREATE INDEX index_name ON table(column(length))
```
(2)删除索引
``` 
DROP INDEX index_name ON table
```
2.唯一索引（索引列的值必须唯一，但允许有空值）

创建索引：
``` 
CREATE UNIQUE INDEX indexName ON table(column(length))
```
3.主键索引（一个表的主键）
``` 
CREATE TABLE `table` (
    `id` int(11) NOT NULL AUTO_INCREMENT ,
    `title` char(255) NOT NULL ,
    PRIMARY KEY (`id`)
);
```
4.组合索引




