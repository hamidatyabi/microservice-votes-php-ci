<?php
use HamidAtyabi\ImageLibrary\Entities\Image;
class VotesModel extends CI_Model{
    
    public function getVoteTotalCount(VoteListRequest $request){
        $this->db->select('votes.id');
        $this->db->from('votes');
        
        if(!is_blank($request->getTitle()))
            $this->db->like("votes.title", $request->getTitle(), "both");
        
        if(!is_blank($request->getVoteId(), true))
            $this->db->where("votes.id", $request->getVoteId());
        
        if(!is_blank($request->getStatus()))
            $this->db->where("votes.status", $request->getStatus());  
        
        return $this->db->count_all_results();
    }
    
    /**
     * 
     *
     * @return Vote[]
     */
    public function getVoteTotalRows(VoteListRequest $request){
        $this->db->select('votes.*');
        $this->db->from('votes');
        
        if(!is_blank($request->getTitle()))
            $this->db->like("votes.title", $request->getTitle(), "both");
        
        if(!is_blank($request->getVoteId(), true))
            $this->db->where("votes.id", $request->getVoteId());
        
        if(!is_blank($request->getStatus()))
            $this->db->where("votes.status", $request->getStatus());  
        
        if(is_blank($request->getPage())) $request->setPage(1);
        if(is_blank($request->getLimit())) $request->setLimit(10);
        
        $this->db->limit($request->getLimit(), (($request->getPage() - 1) * $request->getLimit()));
        $this->db->order_by('votes.id', 'desc');
        $query = $this->db->get();
        $result = array();
        if($query->num_rows() > 0){
            foreach($query->result_array() as $row){
                $vote = new Vote($row['id'], $row['title'], $row['description'], 
                        $row['create_time'], $row['expire_time'], ($row['status'] == 1), 
                        $this->getVoteOptions($row['id']), $this->imageCreator($row));
                $result[] = $vote;
            }
        }
        return $result;
    }
    
    /**
     * 
     *
     * @return VoteOptions[]
     */
    public function getVoteOptions($voteId){
        $this->db->select('options.*');
        $this->db->from('options');
        $this->db->where("options.vote_id", $voteId);
        
        $query = $this->db->get();
        $result = array();
        if($query->num_rows() > 0){
            foreach($query->result_array() as $row){
                $result[] = new VoteOptions($row['id'], $row['vote_id'], $row['key'], $row['description'], $row['create_time']);
            }
        }
        return $result;
    }
    
    /**
     * 
     *
     * @return Vote
     */
    public function getVoteById($voteId)
    {
        $this->db->select('votes.*');
        $this->db->from('votes');
        $this->db->where("votes.id", $voteId);
        
        $query = $this->db->get();
        if($query->num_rows() > 0){
            $row = $query->row_array();
            return new Vote($row['id'], $row['title'], $row['description'], 
                        $row['create_time'], $row['expire_time'], ($row['status'] == 1), 
                        $this->getVoteOptions($row['id']), $this->imageCreator($row));
        }
        return null;
    }
    
    public function insertNewVote(VoteAddRequest $request, Image $image = null): Vote
    {
        $dataInsert = array(
            "title" => $request->getTitle(),
            "description" => $request->getDescription(),
            "create_time" => $request->getCreateTime(),
            "expire_time" => $request->getExpireTime(),
            "status" => $request->getStatus(),
        );
        if($image != null){
            $dataInsert["media"] = ($image != null)?$image->getPath():null;
            $dataInsert["media_size"] = ($image != null)?$image->getSize():null;
            $dataInsert["media_base_dimension"] = ($image != null)?$image->getBaseWidth()."x".$image->getBaseHeight():null;
            $dataInsert["media_crop_dimension"] = ($image != null)?(($image->getWidth() != null)?$image->getWidth():"0")."x".(($image->getHeight() != null)?$image->getHeight():"0"):null;
            $dataInsert["media_mime"] = ($image != null)?$image->getMime():null;
            $dataInsert["media_extension"] = ($image != null)?$image->getExtension():null;
        }
        $this->db->insert('votes', $dataInsert);
        return $this->getVoteById($this->db->insert_id());
    }
    
    public function updateVote(VoteAddRequest $request, Image $image = null): Vote
    {
        $dataUpdate = array(
            "title" => $request->getTitle(),
            "description" => $request->getDescription(),
            "create_time" => $request->getCreateTime(),
            "expire_time" => $request->getExpireTime(),
            "status" => $request->getStatus(),
        );
        if($image != null){
            $dataUpdate["media"] = ($image != null)?$image->getPath():null;
            $dataUpdate["media_size"] = ($image != null)?$image->getSize():null;
            $dataUpdate["media_base_dimension"] = ($image != null)?$image->getBaseWidth()."x".$image->getBaseHeight():null;
            $dataUpdate["media_crop_dimension"] = ($image != null)?(($image->getWidth() != null)?$image->getWidth():"0")."x".(($image->getHeight() != null)?$image->getHeight():"0"):null;
            $dataUpdate["media_mime"] = ($image != null)?$image->getMime():null;
            $dataUpdate["media_extension"] = ($image != null)?$image->getExtension():null;
        }
        $this->db->where('votes.id', $request->getVoteId());
        $this->db->update('votes', $dataUpdate);
        return $this->getVoteById($request->getVoteId());
    }
    
    public function deleteVoteImage($voteId)
    {
        $dataUpdate = array(
            "media" => null,
            "media_size" => 0,
            "media_base_dimension" => null,
            "media_crop_dimension" => null,
            "media_mime" => null,
            "media_extension" => null,
        );
        $this->db->where('votes.id', $voteId);
        $this->db->update('votes', $dataUpdate);
        return $this->getVoteById($voteId);
    }
    
    private function imageCreator($dbRow): Image
    {
        $Image = new Image();
        if(!is_blank($dbRow['media'])){
            $baseDimension = explode("x", $dbRow['media_base_dimension']);
            $cropDimension = explode("x", $dbRow['media_crop_dimension']);
            $Image = new Image();
            $Image->setFileName(basename($dbRow['media']));
            $Image->setPath($dbRow['media']);
            $Image->setBaseWidth($baseDimension[0]);
            $Image->setBaseHeight($baseDimension[1]);
            $Image->setWidth($cropDimension[0]);
            $Image->setHeight($cropDimension[1]);
            $Image->setSize($dbRow['media_size']);
            $Image->setMime($dbRow['media_mime']);
            $Image->setExtension($dbRow['media_extension']);
        }
        return $Image;
    }
}
