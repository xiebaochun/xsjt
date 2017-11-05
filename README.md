# My-PHP-Framework  
一个 MVC 框架

### 写这个框架的原因  
1. 加强自己的 PHP 技能
2. 研究其他 PHP 框架源码的时候更轻松，通过对比相信收获也会更多
3. 希望以后做小项目可以使用这个框架

### 参考  
1. 从零开始打造自己的PHP框架 [慕课网] http://www.imooc.com/learn/696 
2. thinkphp 5.0 源码

### 相对于慕课网中的框架的改进
1. 考虑了不同操作系统中的差异,使之支持windows系统
2. 配置文件统一在一个目录中,而不是分布在不同目录不同文件中
3. 新增 request 类,操作 get 和 post 数据
4. 支持 nginx,虽然不能隐藏 index.php
5. 配置类改进
6. 提供 CSRF 防护
7. 新增缓存类

### 目前这个框架的主要不足
1. 入口文件在根目录，在web服务配置不当时，有代码泄露的风险，下个版本将改进

### 环境
1. php7
2. nginx
3. composer
4. redis
5. mysql