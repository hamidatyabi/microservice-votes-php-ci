<?php
class VoteAddRequest implements JsonSerializable{
    private $voteId;
    private $title;
    private $description;
    private $createTime;
    private $expireTime;
    private $status;
    private $media;
    
    function __construct($parent = null) {
        if($parent != null){
            $parent->checkAuthorities(array("ROLE_SUPER_ADMIN"));
            $CI =& get_instance();
            if($CI->input->method() == 'post'){
                $bodyRequest = json_decode($CI->input->raw_input_stream, true);
                if(!empty($bodyRequest)){
                    foreach (get_object_vars($this) as $key => $value) {
                        if(array_key_exists($key, $bodyRequest)) $this->$key = $bodyRequest[$key];
                    }
                }
                foreach (get_object_vars($this) as $key => $value) {
                    if($CI->input->post($key) != null) $this->$key = $CI->input->post($key);
                }
            }else if($CI->input->method() == 'get'){
                foreach (get_object_vars($this) as $key => $value) {
                    if($CI->input->get($key) != null) $this->$key = $CI->input->get($key);
                }
            }
        }
        
        
    }
    
    function getVoteId() {
        return $this->voteId;
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

    function getMedia() {
        return $this->media;
    }

    function setVoteId($voteId) {
        $this->voteId = $voteId;
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

    function setMedia($media) {
        $this->media = $media;
    }

    
        
    public function jsonSerialize()
    {
        return [
            'voteAddRequest' => [
                'voteId' => $this->voteId,
                'title' => $this->title,
                'description' => $this->description,
                'createTime' => $this->createTime,
                'expireTime' => $this->expireTime,
                'status' => $this->status,
                'media' => $this->media
            ]
        ];
    }

}