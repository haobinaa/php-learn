# 单点登录

再次之前要记录一下另一种形式，单个账号同时只能有一个用户登录，之前在乐望做开发的时候，每个账号的后台登录都只能一个人：  
1. 首先是把session存到redis而非服务器文件，登录后把session_id存到mysql某个字段
2. 验证用户名密码登录后，取出mysql的session_id字段，然后删除redis下该session_id的key-value。这样就做到上一个登录的人，无法找到对应的session，也就是退出。然后把新的session_id更新到mysql相应的字段


##### 单点登录（single sign on   简称SSO）