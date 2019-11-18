<?php

class VoteOptions implements JsonSerializable{
    private $id;
    private $voteId;
    private $key;
    private $description;
    private $createTime;
            
    function __construct($id = 0, $voteId = 0, $key = '', $description = '', $createTime = '') {
        $this->id = $id;
        $this->voteId = $voteId;
        $this->description = $description;
        $this->key = $key;
        $this->createTime = $createTime;
    }

    
    function getId() {
        return $this->id;
    }

    function getVoteId() {
        return $this->voteId;
    }

    function getKey() {
        return $this->key;
    }

    function getDescription() {
        return $this->description;
    }

    function getCreateTime() {
        return $this->createTime;
    }

    function setId($id) {
        $this->id = $id;
    }

    function setVoteId($voteId) {
        $this->voteId = $voteId;
    }

    function setKey($key) {
        $this->key = $key;
    }

    function setDescription($description) {
        $this->description = $description;
    }

    function setCreateTime($createTime) {
        $this->createTime = $createTime;
    }

    
    public function jsonSerialize()
    {
        return [
            'id' => $this->id,
            'voteId' => $this->voteId,
            'description' => $this->description,
            'createTime' => $this->createTime,
            'key' => $this->key
        ];
    }
}
