<?php
//加载twig模版引擎
$loader = new Twig_Loader_Filesystem('src/views/');
$twig = new Twig_Environment($loader, array(
    //'cache' => '../runtime/',  //开启视图缓存选项
));
//加载main视图
$mianView = $twig->load('main.html');

//配置数据库
$dbserver = "localhost";
$dbusername = "root";
$dbpassword = "xiaoxin820520";
$database = "tongcms";
$mysqli_conn = @mysqli_connect("$dbserver", "$dbusername", "$dbpassword") or die("Mysql connect is error.");
mysqli_select_db($mysqli_conn, $database);
mysqli_query($mysqli_conn, 'SET NAMES utf8');

//取得所有的表名
$table_result = mysqli_query($mysqli_conn, 'show tables');
//取得所有的表
$tables = array();
while ($row = mysqli_fetch_array($table_result)) {
    $tables[]['TABLE_NAME'] = $row[0];
}
//循环取得所有表的备注及表中列消息
foreach ($tables as $k => $v) {
    $sql = 'SELECT * FROM INFORMATION_SCHEMA.TABLES WHERE `table_name` = "' . $v['TABLE_NAME'] . '" AND `table_schema` = "' . $database . '"';
    $table_result = mysqli_query($mysqli_conn, $sql);
    while ($t = mysqli_fetch_array($table_result)) {
        $tables[$k]['TABLE_COMMENT'] = $t['TABLE_COMMENT'];
    }
    $sql = 'SELECT * FROM INFORMATION_SCHEMA.COLUMNS WHERE `table_name` = "' . $v['TABLE_NAME'] . '" AND `table_schema` = "' . $database . '"';
    $fields = array();
    $field_result = mysqli_query($mysqli_conn, $sql);
    while ($t = mysqli_fetch_array($field_result)) {
        $fields[] = $t;
    }
    $tables[$k]['COLUMN'] = $fields;
}
mysqli_close($mysqli_conn);

//输出视图
echo $mianView->render(['tables' => $tables]);
