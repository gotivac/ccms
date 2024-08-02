<?php

class UserIdentity extends CUserIdentity {

    private $id;

    public function authenticate() {
        $record = User::model()->find(array("condition" => "email='$this->username' AND active=1"));
       
        if ($record === null) {
             
            $this->errorCode = self::ERROR_USERNAME_INVALID;
            
        } else if ($record->password !== md5($this->password)) {
            
            $this->errorCode = self::ERROR_PASSWORD_INVALID;
            
        } else {
            $this->id = $record->id;
            
            
            $this->setState('roles', $record->roles);
            $this->setState('name', $record->name);
            $this->errorCode = self::ERROR_NONE;
        }
        
        return !$this->errorCode;
    }

    public function getId() {
        return $this->id;
    }

}
