<?php

class VoteListRequest implements JsonSerializable{
    private $title;
    private $voteId;
    private $status;
    private $page = 1;
    private $limit = 10;
    function __construct($parent = null) {
        if($parent != null){
            $parent->checkAuthorities(array("*"));
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
    
    function getTitle() {
        return $this->title;
    }

    function getVoteId() {
        return $this->voteId;
    }

    function getStatus() {
        return $this->status;
    }

    function setTitle($title) {
        $this->title = $title;
    }

    function setVoteId($voteId) {
        $this->voteId = $voteId;
    }

    function setStatus($status) {
        $this->status = $status;
    }
    
    function getPage() {
        return $this->page;
    }

    function getLimit() {
        return $this->limit;
    }

    function setPage($page) {
        $this->page = $page;
    }

    function setLimit($limit) {
        $this->limit = $limit;
    }

        
    public function jsonSerialize()
    {
        return [
            'voteListRequest' => [
                'title' => $this->title,
                'voteId' => $this->voteId,
                'status' => $this->status,
                'page' => $this->page,
                'limit' => $this->limit
            ]
        ];
    }

}
