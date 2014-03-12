<?php
namespace Algorithm;
class AhoCorasick {

    public $nodeTree;
    public $root;

    public function __construct(){
        $this->nodeTree = new NodeTree();
        $this->root = 0;
    }

    public function build_tree($keywords){
        
        if (is_array($keywords)) {
            foreach($keywords as $kw){
                $nd = $this->root;
                $chars = preg_split('//u', $kw, -1, PREG_SPLIT_NO_EMPTY);
                foreach($chars as $ch) {
                    $ndNew = $this->nodeTree->getTransition($nd, $ch);
                    if (!$ndNew) {
                        $ndNew = $this->nodeTree->addNode($nd, $ch);
                    }
                    $nd = $ndNew;
                }
                $this->nodeTree->addResult($nd, $kw);
            }
            $nodes = array();
            //设置第一层失败指向
            $firstNodes = $this->nodeTree->getTransitions($this->root);
            if (is_array($firstNodes)) {
                foreach ($this->nodeTree->getTransitions($this->root) as $node) {
                    $this->nodeTree->setFailure($node, $this->root);
                    if ($this->nodeTree->getTransitions($node) !== null) {
                        foreach ($this->nodeTree->getTransitions($node) as $val) {
                            $nodes[] = $val;
                        }
                    }
                }
            }
            //设置余下每一层失败指向
            while(count($nodes) > 0) {
                $nodesNew = array();
                foreach ($nodes as $node) {
                    $pf = $this->nodeTree->getFailure($this->nodeTree->getParent($node));//failureid of parentid
                    $s = $this->nodeTree->getChar($node);
                    $childId = $this->nodeTree->getTransition($pf, $s);
                    while ($pf !== null && $childId === null) {
                        $pf = $this->nodeTree->getFailure($pf);
                    }
                    if ($pf === null) {
                        $this->nodeTree->setFailure($node, $this->root);
                    } else {
                        $failId = $this->nodeTree->getTransition($pf, $s);
                        $this->nodeTree->setFailure($node, $failId);
                        $results = $this->nodeTree->getResults($failId);
                        if ($results !== null) {
                            foreach ($results as $res) {
                                $this->nodeTree->addResult($node, $res);
                            }
                        }
                    }
                    if ($this->nodeTree->getTransitions($node) !== null) {
                        foreach ($this->nodeTree->getTransitions($node) as $child) {
                            $nodesNew[] = $child;
                        }
                    }
                }
                $nodes = $nodesNew;
            }
            $this->nodeTree->setFailure($this->root, $this->root);
            return $this->nodeTree;
        } else {
            return false;
        }
    }

    public function find($inputText) {
        $ret = array();
        $nodeTree = $this->nodeTree;
        $state = $this->root;
        $index = 0;
        $len = mb_strlen($inputText, "UTF8");
        while ($index < $len) {
            $trans = null;
            while (true) {
                $char = mb_substr($inputText, $index, 1, "UTF8");
                $trans = $nodeTree->getTransition($state, $char);
                if ($state === $this->root || $trans !== null) {
                    break;
                } elseif ($trans === null) {
                    $state = $nodeTree->getFailure($state);
                }
            }
            if ($trans !== null) {
                $state = $trans;
            }
            $all = $nodeTree->getResults($state);
            if ($all !== null) {
                foreach ($all as $found) {
                    array_push($ret,array("kw"=>"$found","end"=>"$index","len"=>mb_strlen($found, "UTF8")));
                }
            }
            $index++;
        }
        return $ret;
    }

    public function replace($inputText){
        $ret = $this->find($inputText);
        foreach ($ret as $r) {
            $before = mb_substr($inputText, 0, $r['end'] + 1 - mb_strlen($r['kw'], "UTF8"), "UTF8");
            $replace = str_repeat("*", mb_strlen($r['kw'], "UTF8"));
            $after = mb_substr($inputText, $r['end'] + 1, mb_strlen($inputText, "UTF8") - $r['end'] - 1, "UTF8");
            $inputText = $before . $replace . $after;   
        }
        $ret = array_merge($ret, array("replaced"=>$inputText));
        return $ret;
    }
}
