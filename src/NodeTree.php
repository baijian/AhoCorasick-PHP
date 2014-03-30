<?php
namespace Baijian\Algorithm;
class NodeTree {
    
    public $parentId = array();
    public $char = array();
    public $results = array();
    public $transitions = array();
    public $failureId = array();
    public $counter;

    public function __construct() {
        $this->counter = 0;
        $this->parentId[$this->counter] = null;
        $this->char[$this->counter] = null;
        $this->results[$this->counter] = null;
        $this->transitions[$this->counter] = null;
        $this->failureId[$this->counter] = null;
        $this->counter++;
    }
    
    public function addNode($parentId, $c) {
        $this->parentId[$this->counter] = $parentId;
        $this->char[$this->counter] = $c;
        $this->transitions[$parentId][$c] = $this->counter;
        return $this->counter++;
    }

    public function getChar($nodeId) {
        return $this->char[$nodeId];
    }

    public function addResult($nodeId, $str) {
        $this->results[$nodeId][] = $str;
    }

    public function getResults($nodeId) {
        return isset($this->results[$nodeId])?$this->results[$nodeId]:null;
    }
    
    public function setFailure($nodeId, $failId) {
        $this->failureId[$nodeId] = $failId;
    }

    public function getFailure($nodeId) {
        return $this->failureId[$nodeId];
    }

    public function getParent($nodeId) {
        return $this->parentId[$nodeId];
    }

    public function getTransition($nodeId, $c) {
        return isset($this->transitions[$nodeId][$c])?$this->transitions[$nodeId][$c]:null;
    }

    public function getTransitions($nodeId) {
        return isset($this->transitions[$nodeId])?$this->transitions[$nodeId]:null;
    }
}
