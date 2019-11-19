<?php

class ErrorResponse implements JsonSerializable{
    private $error;
    private $description;
    function __construct($error = '', $description = '') {
        $this->error = $error;
        $this->description = $description;
    }

    function getError() {
        return $this->error;
    }

    function getDescription() {
        return $this->description;
    }

    function setError($error) {
        $this->error = $error;
    }

    function setDescription($description) {
        $this->description = $description;
    }

            
    public function jsonSerialize()
    {
        return [
            'error' => $this->error,
            'description' => $this->description
        ];
    }

}