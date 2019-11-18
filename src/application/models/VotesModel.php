<?php
class VotesModel extends CI_Model{
    
    public function getVoteTotalCount(VoteListRequest $request){
        $this->db->select('votes.id');
        $this->db->from('votes');
        
        if(!is_blank($request->getTitle()))
            $this->db->like("votes.title", $request->getTitle(), "both");
        
        if(!is_blank($request->getVoteId(), true))
            $this->db->where("votes.vote_id", $request->getVoteId());
        
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
            $this->db->where("votes.vote_id", $request->getVoteId());
        
        if(!is_blank($request->getStatus()))
            $this->db->where("votes.status", $request->getStatus());  
        
        if(is_blank($request->getPage())) $request->setPage(1);
        if(is_blank($request->getLimit())) $request->setLimit(10);
        
        $this->db->limit($request->getLimit(), (($request->getPage() - 1) * $request->getLimit()));
        
        $query = $this->db->get();
        $result = array();
        if($query->num_rows() > 0){
            foreach($query->result_array() as $row){
                $result[] = new Vote($row['id'], $row['title'], $row['description'], 
                        $row['create_time'], $row['expire_time'], ($row['status'] == 1), 
                        $this->getVoteOptions($row['id']));
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
}
