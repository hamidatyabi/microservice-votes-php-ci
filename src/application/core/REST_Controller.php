<?php
defined('BASEPATH') OR exit('No direct script access allowed');
use HamidAtyabi\OAuth2Client\AccessToken\AccessToken;
use HamidAtyabi\OAuth2Client\Models\TokenInfoResponse;
use HamidAtyabi\OAuth2Client\Entities\TokenInfo;

class REST_Controller extends CI_Controller{
    private $tokenInfo;
    public function __construct() {
        parent::__construct();
        
        $this->config->load('oauth2');
        $config = array(
            "oauth2_host" => $this->config->item('oauth2_host'),
            "oauth2_port" => $this->config->item('oauth2_port'),
            "oauth2_client_id" => $this->config->item('oauth2_client_id'),
            "oauth2_client_secret" => $this->config->item('oauth2_client_secret'),
            "oauth2_resource_id" => $this->config->item('oauth2_resource_id')
        );
        $client = new \HamidAtyabi\OAuth2Client\AccessToken\AccessToken($config);
        $this->tokenInfo = $client->validity();
        if($this->tokenInfo->getCode() != 200) $this->response ($this->tokenInfo->getCode(), $this->tokenInfo->getMessage());
        
    }
    /**
     * 
     * @return TokenInfoResponse
     */
    protected function getTokenInfo(){
        return $this->tokenInfo;
    }
    
    public function checkAuthorities($allowRoles){
        foreach($allowRoles as $role){
            if($role == "*" || in_array($role, $this->getTokenInfo()->getResult()->getAuthorities()))
                return true;
        }
        $this->response(403, "Access denied.");
    }

    protected function response($status, $result){
        http_response_code($status);
        header('Content-Type: application/json');
        if($status == 200){
            echo json_encode($result);
            exit();
        }
        echo json_encode(array(
            "error_code" => $status,
            "error" => $result
        ));
        exit();
    }
}
