<?php

class VoteListResponse implements JsonSerializable{
    private $totalCount;
    private $currentPage;
    private $currentLimit;
    private $totalPage;
    private $rows;
    function __construct() {
        
    }
    /**
     * 
     *
     * @return int
     */
    function getTotalCount() {
        return $this->totalCount;
    }
    
    /**
     * 
     *
     * @return Vote
     */
    function getRows() {
        return $this->rows;
    }

    function setTotalCount($totalCount) {
        $this->totalCount = $totalCount;
    }

    function setRows($rows) {
        $this->rows = $rows;
    }
    
    function getCurrentPage() {
        return $this->currentPage;
    }

    function getCurrentLimit() {
        return $this->currentLimit;
    }

    function setCurrentPage($currentPage) {
        $this->currentPage = $currentPage;
    }

    function setCurrentLimit($currentLimit) {
        $this->currentLimit = $currentLimit;
    }
    
    function getTotalPage() {
        return $this->totalPage;
    }

    function setTotalPage($totalPage) {
        $this->totalPage = $totalPage;
    }

    
    
        
    public function jsonSerialize()
    {
        return [
            'totalCount' => $this->totalCount,
            'currentPage' => $this->currentPage,
            'currentLimit' => $this->currentLimit,
            'totalPage' => $this->totalPage,
            'rows' => $this->rows
        ];
    }

}
