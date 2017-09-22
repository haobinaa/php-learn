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