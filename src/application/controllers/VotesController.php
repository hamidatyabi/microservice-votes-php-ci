<?php
defined('BASEPATH') OR exit('No direct script access allowed');
use \HamidAtyabi\OAuth2Client;

class VotesController extends REST_Controller {
    private $model;
    public function __construct() {
        parent::__construct();
        $this->load->model('VotesModel');
        $this->model = $this->VotesModel;
    }
    
    public function list()
    {
        $VoteListRequest = new VoteListRequest($this);
        $VoteListResponse = new VoteListResponse();
        $VoteListResponse->setTotalCount($this->model->getVoteTotalCount($VoteListRequest));
        $VoteListResponse->setRows($this->model->getVoteTotalRows($VoteListRequest));
        $VoteListResponse->setCurrentPage($VoteListRequest->getPage());
        $VoteListResponse->setCurrentLimit($VoteListRequest->getLimit());
        $VoteListResponse->setTotalPage(ceil($VoteListResponse->getTotalCount() / $VoteListRequest->getLimit()));
        $this->response(200, $VoteListResponse);
    }
}
