# WEB安全简介
### 一、SQL注入攻击(SQL Injection)

攻击者把sql命令插入到web表单的输入域或页面请求的字符串，欺骗服务器执行恶意的sql命令。常见的sql注入攻击类似：

1. 登录页面中输入内容直接用来构造动态的sql语句，例如：
``` 
$query = 'select * from users where login = '. $username. 'and password = '. $password;
```
攻击者如果在用户名或者密码框输入`or '1' =1`，这样我们执行的sql语句就变成了：
```
select * from users where login = '' or '1' = 1 and ...
```
这样就绕过了我们的登录验证。类似的还有很多，用户通过输入恶意的sql命令来绕过我们的验证，欺骗我们的系统。

防范的方法：
1. 检查变量数据类型和格式
2. 过滤特殊的符号
3. 绑定变量，使用预处理语句（当我们绑定变量的时候，就算有特殊字符sql也会认为是个变量而不是sql命令）

### 二、跨站脚本攻击(Cross Site Scripting, XSS；因为CSS被用了所以叫XSS)

攻击者将恶意代码注入到网页上，其他用户在加载网页时就会执行代码，攻击者可能会得到各种私密的信息，如cookie等。例如：
``` 
<?php
    echo '你好！'.$_GET['name'];
```
如果用户传入一段脚本`<script>[code]</script>`，那么脚本也会执行，如果code的内容是获取到cookie并发送到某个指定的位置，获取了敏感的信息。亦或是利用用户的身份去执行一些不正当的操作。

防范的方法：
1. 输出的时候过滤特殊的字符，转换成html编码，过滤输出的变量（PHP可以使用htmlspecialchars）

### 三、跨站请求伪造攻击(Cross Site Request Forgeries, CSRF)

攻击者伪造目标用户的HTTP请求，然后此请求发送到有CSRF漏洞的网站，网站执行此请求后，引发跨站请求伪造攻击。攻击者利用隐蔽的HTTP连接，让目标用户在不注意的情况下单击这个链接，由于是用户自己点击的，而他又是合法用户拥有合法权限，所以目标用户能够在网站内执行特定的HTTP链接，从而达到攻击者的目的。  
例如：  
用户刚刚登陆了银行A网站，建立了会话，A网站可以进行转账操作`http://www.mybank.com/Transfer.php?toBankId=11&money=1000`在没有退出的情况下去访问危险网站B网站，B网站有一个图片是这样的`　<img src=http://www.mybank.com/Transfer.php?toBankId=11&money=1000>`，不小心点了B网站，用户发现账上少了1000块。  
    可能有人会说，修改操作并不会用get请求。那么假设银行A网站的表单如下
``` 
<form action="Transfer.php" method="POST">
    <p>ToBankId: <input type="text" name="toBankId" /></p>
    <p>Money: <input type="text" name="money" /></p>
    <p><input type="submit" value="Transfer" /></p>
</form>
```
后台处理页面如下：
``` 
<?php
session_start();
if (isset($_REQUEST['toBankId'] && isset($_POST['money']))
{
    buy_stocks($_REQUEST['toBankId'],$_REQUEST['money']);
}
?>
```
B网站这时候也相应的改了代码:
```
<html>
    <head>
　　　　<script type="text/javascript">
　　　　　　function steal()
　　　　　　{
          　　　　 iframe = document.frames["steal"];
　　     　　      iframe.document.Submit("transfer");
　　　　　　}
　　　　</script>
　　</head>

　　<body onload="steal()">
　　　　<iframe name="steal" display="none">
　　　　　　<form method="POST" name="transfer"　action="http://www.myBank.com/Transfer.php">
　　　　　　　　<input type="hidden" name="toBankId" value="11">
　　　　　　　　<input type="hidden" name="money" value="1000">
　　　　　　</form>
　　　　</iframe>
　　</body>
</html>
```
用户一点到B网站，发现又少了1000块.......

防范方法：
    对表单进行cookie hash校验，将一个随机值的hash写入cookie，每次提交表单，都在服务端对这个hash进行校验（建立在用户的cookie没有被盗取）
    
### 四、Session固定攻击(Session Fixation)
### 五、Session劫持(Session Hijacking)
### 六、文件上传漏洞(File Upload Attack)