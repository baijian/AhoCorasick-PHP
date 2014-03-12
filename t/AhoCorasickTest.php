<?php
use Baijian\Algorithm\AhoCorasick;
use Baijian\Algorithm\NodeTree;

ini_set('display_errors', '1');
ini_set('error_reporting', '1');

class AhoCorasickTest extends PHPUnit_Framework_TestCase {
}
/*
$keywords = array('好','acf','bc');
$inputText = "你好吗bc";

$ac = new AhoCorasick();//初始化搜索树(初始化树根)
$tree = $ac->build_tree($keywords);//建立关键词搜索树
//var_dump($tree);
$ret = $ac->replace($inputText);//拿内容进去搜索
var_dump($ret);
 */
