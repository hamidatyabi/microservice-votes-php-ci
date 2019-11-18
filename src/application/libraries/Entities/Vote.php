<?php

class Vote implements JsonSerializable{
    private $id;
    private $title;
    private $description;
    private $createTime;
    private $expireTime;
    private $status;
    private $options;
            
    function __construct($id = 0, $title = '', $description = '', $createTime = '', 
            $expireTime = '', $status = false, $options = null) {
        $this->id = $id;
        $this->title = $title;
        $this->description = $description;
        $this->createTime = $createTime;
        $this->expireTime = $expireTime;
        $this->status = $status;
        $this->options = $options;
    }

    
    function getId() {
        return $this->id;
    }

    function getTitle() {
        return $this->title;
    }

    function getDescription() {
        return $this->description;
    }

    function getCreateTime() {
        return $this->createTime;
    }

    function getExpireTime() {
        return $this->expireTime;
    }

    function getStatus() {
        return $this->status;
    }

    function setId($id) {
        $this->id = $id;
    }

    function setTitle($title) {
        $this->title = $title;
    }

    function setDescription($description) {
        $this->description = $description;
    }

    function setCreateTime($createTime) {
        $this->createTime = $createTime;
    }

    function setExpireTime($expireTime) {
        $this->expireTime = $expireTime;
    }

    function setStatus($status) {
        $this->status = $status;
    }
    
    function getOptions() {
        return $this->options;
    }

    function setOptions($options) {
        $this->options = $options;
    }

    
    public function jsonSerialize()
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'description' => $this->description,
            'createTime' => $this->createTime,
            'expireTime' => $this->expireTime,
            'status' => $this->status,
            'options' => $this->options
        ];
    }
}
