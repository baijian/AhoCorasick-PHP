<?php
ini_set('display_errors', '1');
ini_set('error_reporting', '1');
require_once 'vendor/autoload.php';

use Baijian\Algorithm\AhoCorasick,
    Baijian\Algorithm\NodeTree;

$keywords = array('好', 'fuck', 'hello');
$input = 'helloworld,你好,fuck!';
$ac = new Baijian\Algorithm\AhoCorasick();//初始化搜索树(初始化树根)
$tree = $ac->build_tree($keywords);//建议关键词搜索树
//var_dump($tree);
$ret = $ac->replace($input);//search
print_r($ret);
