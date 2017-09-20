# 索引
### 一、 创建索引
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
4.组合索引（将多个列组合在一起创建索引）


### 二、索引创建的原则和注意事项
1. 最适合创建索引的是出现在where子句中的列或是出现在连接子句中的列
2. 对字符串类型进行索引的时候，应该指定一个前缀长度，比如索引前多少个字符  
3. 根据业务情况创建组合索引（比如某个业务需要查询两个列）
4. 组合索引遵循前缀原则（最左前缀原则）TODO  
5. like查询，%不能在前，可以使用全文检索引擎

>例如： where name like '%wang%'，查询姓名中有wang的，此时索引不会生效，还是会全表扫描，因为前面有个%，如果是like 'wang%'这样会使用到索引，但是没有前缀匹配了，如果想达到索引的效果，可以使用全文检索引擎，例如es（Elasticsearch）

6.如果mysql觉得全表扫描比索引扫描快，他会自动放弃使用索引

7.但是






