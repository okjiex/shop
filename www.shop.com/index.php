<?php
header('Content-Type: text/html;charset=utf8');
//���php�汾 ����5.3�Ͳ�������
version_compare(PHP_VERSION,'5.3','>') or exit('�汾����!');
//������Ŀ��Ŀ¼
define('ROOT_PATH',dirname($_SERVER['SCRIPT_FILENAME']).'/');
//加载图片upload地址
define('UPLOAD_PATH',ROOT_PATH.'Upload/');
//������Ŀ¼
define('THINK_PATH',dirname(ROOT_PATH).'/ThinkPHP/');

//var_dump(ROOT_PATH);
//����Ӧ��Ŀ¼
define('APP_PATH',ROOT_PATH.'Application/');
//��������Ŀ¼(Runtime)
define('RUNTIME_PATH',ROOT_PATH.'Runtime/');
//�趨����ģʽ
define('APP_DEBUG',true);
//��Ĭ��ģ��
define('BIND_MODULE','Admin');
//����thinkphp����ļ�
require THINK_PATH.'ThinkPHP.php';