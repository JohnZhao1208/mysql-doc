# mysql-doc
自动生成mysql数据库的数据字典

## 简介

* 使用 mysqli 进行数据库操作
* 使用 twig 模版引擎渲染视图
* 生成的字典内容，依赖于mysql数据表的表结构以及字段注释内容

## 使用方法

使用命令

```
composer install
```

修改 `src/domain/doc.php `

```php
//配置数据库
$dbserver = "hostname";
$dbusername = "dbusername";
$dbpassword = "dbpassword";
$database = "dbname";
```

修改好后，访问 根目录下 `index.php`

