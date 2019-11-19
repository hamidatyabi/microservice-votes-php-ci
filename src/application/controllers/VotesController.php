<?php
defined('BASEPATH') OR exit('No direct script access allowed');

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
    
    public function add()
    {
        $VoteAddRequest = new VoteAddRequest($this);
        if(is_blank($VoteAddRequest->getTitle())) $this->response(400, "Title can't be empty.");
        if(is_blank($VoteAddRequest->getCreateTime())) $VoteAddRequest->setCreateTime(date("Y-m-d H:i:s"));
        if(is_blank($VoteAddRequest->getExpireTime())) $VoteAddRequest->setExpireTime(date('Y-m-d H:i:s', strtotime('+1 years')));
        if(!is_bool($VoteAddRequest->getStatus())) $VoteAddRequest->setStatus(true);
        $Image = null;
        if(!is_blank($VoteAddRequest->getMedia())){
            try{
                $ImageDecoder = new HamidAtyabi\ImageLibrary\ImageDecoder($VoteAddRequest->getMedia(), array("jpeg", "png", "gif"));
                $Image = $ImageDecoder->upload("uploads/");
            } catch (Exception $ex) {
                $this->response(400, new ErrorResponse("media_upload_error", $ex->getMessage()));
            } 
        }
        try{
            $voteInserted = $this->model->insertNewVote($VoteAddRequest, $Image);
            $this->response(200, $voteInserted);
        } catch (Exception $ex) {
            $this->response(500, new ErrorResponse("insert_vote_error", $ex->getMessage()));
        }
        $this->response(500, "Internal server error");
    }
    
    public function update()
    {
        $VoteAddRequest = new VoteAddRequest($this);
        
        $vote = $this->model->getVoteById($VoteAddRequest->getVoteId());
        if($vote == null) $this->response(400, "VoteId is incorrect");
        
        if(is_blank($VoteAddRequest->getTitle())) $VoteAddRequest->setTitle($vote->getTitle());
        if(is_blank($VoteAddRequest->getDescription())) $VoteAddRequest->setDescription($vote->getDescription());
        if(is_blank($VoteAddRequest->getCreateTime())) $VoteAddRequest->setCreateTime($vote->getCreateTime());
        if(is_blank($VoteAddRequest->getExpireTime())) $VoteAddRequest->setExpireTime($vote->getExpireTime());
        if(!is_bool($VoteAddRequest->getStatus())) $VoteAddRequest->setStatus($vote->getStatus());
        $Image = null;
        if(!is_blank($VoteAddRequest->getMedia())){
            try{
                $ImageDecoder = new HamidAtyabi\ImageLibrary\ImageDecoder($VoteAddRequest->getMedia(), array("jpeg", "png", "gif"));
                $Image = $ImageDecoder->upload("uploads/");
            } catch (Exception $ex) {
                $this->response(400, new ErrorResponse("media_upload_error", $ex->getMessage()));
            } 
        }
        try{
            $voteUpdated = $this->model->updateVote($VoteAddRequest, $Image);
            $this->response(200, $voteUpdated);
        } catch (Exception $ex) {
            $this->response(500, new ErrorResponse("insert_vote_error", $ex->getMessage()));
        }
        $this->response(500, $VoteAddRequest);
    }
    
    public function delete_image()
    {
        $voteId = $this->input->get("voteId");
        $this->checkAuthorities(array("ROLE_SUPER_ADMIN"));
        $vote = $this->model->getVoteById($voteId);
        if($vote == null) $this->response(400, "VoteId is incorrect");
        if($vote->getMedia()->getPath() == null) $this->response(400, "This vote don't have media");
        
        try{
            $voteUpdated = $this->model->deleteVoteImage($voteId);
            unlink($vote->getMedia()->getPath());
            $this->response(200, $voteUpdated);
        } catch (Exception $ex) {
            $this->response(500, new ErrorResponse("insert_vote_error", $ex->getMessage()));
        }
        $this->response(500, $vote->getMedia()->getPath());
    }
    
    public function get()
    {
        $voteId = $this->input->get("voteId");
        $this->checkAuthorities(array("*"));
        $vote = $this->model->getVoteById($voteId);
        if($vote == null) $this->response(400, "VoteId is incorrect");
        
        $this->response(200, $vote);
    }
    
}
