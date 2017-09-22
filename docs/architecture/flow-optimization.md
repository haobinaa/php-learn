# 流量优化方案

### 一、防盗链

- 盗链  
1. 概念：  
在自己的页面上展示一些并不在自己服务器上的内容。  
获取他人服务器上的资源地址，绕过别人的资源展示页面，直接在自己的页面上向用户输出  
防盗链则是防止别人通过技术手段盗取本站的资源，让不是本站展示的资源链接失效

2. 防盗链原理：  
通过referer或者签名（在资源地址后面带上一串签名，每次收到请求验证签名），网站可以检测目标访问的来源网页，如果是资源文件，则可以跟踪到他显示的网页地址。一旦检测到来源不是本站则进行组织或者返回指定页面。

3. 实现  
Referer
``` 
Nginx模块 ngx_http_referer_module 用来阻挡来源非法的域名请求
Nginx指令 valid_referers 全局变量$invalid_referer

valid_referers none|blocked|server_names|string....;
none: referer 来源头部为空
blocked: referer不为空，但是里面的值被代理或者防火墙删除了，这些值并不以http：//或者https://开头
server_names: referer来源头部包含当前的server_names

例如：
location ~ .*\.(gif|jpeg|png|flv|swf|rar|zip)$
{
    valid_referer none blocked haobin.com *.haobin.com;
    if($invalid_referer)
    {
        #return 403;
        rewrite ^/http://www.haobin.com/403.html;
    }
}
```
如果有人伪造referer，可以通过签名的方法解决  
加密签名
``` 
通过第三方模块HttpAccessKeyModule实现Nginx防盗链
首先安装这个模块
accesskey on|off    模块开关
accesskey_hashmethod md5 | sha-1    指定签名加密方式
accesskey_arg    GET参数的名称
accesskey_signature     加密规则

例如：
location ~ .*\.(gif|jpeg|png|flv|swf|zip|rar)$
{
    accesskey on;
    accesskey_hashmethod md5;
    accesskey_arg "key";
    accesskey_signature "sign$remote_addr";
}
```

### 二、减少HTTP请求

性能黄金法则：  
只有10%-20%的最终用户响应时间花在接受请求的HTML文档上，剩下的80%-90%时间花在HTML文档所引用的组件（图片、css、script等）进行的http请求上

1. 图片地图：允许在一个图片上关联多个url，目标的url选择取决于用户单击了图片上的哪个位置。  
例如有五张图片，每张图片对应一个超链接。此时就产生了五个http请求，我们将五张图片合成为一张图片，然后以图片的位置定位超链接。
``` 
实现
<map>
    <area></area>
    <area></area>
    <area></area>
    ........
</map> 
```
2.CSS Sprites（CSS 精灵）  
通过使用合并图片，指定css的background-image和background-position来显示元素
``` 
background-position属性
background-position:x,y; x和y可以写正值也可以写负值，我们可以想象图片左上方(0,0)，以(0,0)坐标向右的是负数的x轴，以(0,0)坐标向下的是负数的y轴
```
3.合并脚本和样式表

4.图片使用base64编码减少页面请求数  
>采用Base64编码直接将图片嵌入网页当中

### 三、浏览器缓存和压缩技术
1.HTTP缓存机制  
缓存分类：
> http缓存类型中，请求成功会有三种情况：
200 from cache：直接从本地缓存中获取相应，最快速，最省流量（network的size字段）  
304 not modify： 协商缓存，浏览器在没有命中的情况下请求头中发送一定的校验数据到服务端，如果服务端没有改变，浏览器从本地缓存相应，返回304。 该方式，只返回一些基本的头信息，不发送实际的相应体
200 ok： 以上两种缓存失败，服务器返回完整的相应。 该方式没有用到缓存，是最慢的。

2.设置相应的Header去读取本地缓存
``` 
Program： HTTP1.0的属性，该字段设置为no-cache，会告知浏览器禁用本地缓存

Expires: HTTP1.0的属性，用来启用本地缓存。expires的值对应为一个类似
Thu, 31 Dec 2017 20:11:20 GMT的格林威治时间，告诉浏览器如果还没有到该时间，则缓存有效，无须发送请求。这个时间是服务器返回的，是以服务器的时间为基准，如果服务器和客户端的时间不一致就可能产生差错。

Cache-Control: 告知浏览器缓存过期的时间间隔。
no-store: 禁止浏览器缓存
no-cache: 不允许直接使用本地缓存，先发起请求和服务器协商
max-age=delta-seconds: 告知浏览器响应本地缓存的最长期限，以秒为单位

优先级：Program > Cache-Control > Expires
```
