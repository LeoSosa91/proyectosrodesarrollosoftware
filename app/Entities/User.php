<?php
namespace App\Entities;
use CodeIgniter\Entity\Entity;

class User extends Entity
{
    protected $dates = ['created_at', 'updated_at', 'deleted_at'];

    protected function setPassword(string $pass){
        $this->attributes['password'] = password_hash($pass, PASSWORD_DEFAULT);
        return $this;
    }

    public function getIDUser(){
         
        return $this->attributes['id_user'];
    }
    public function getPassword(){
        return $this->attributes['password'];
    }
    public function getUsername(){
         
        return $this->attributes['username'];
    }

    public function getUsersurname()
    {
        return $this->attributes['usersurname'];
    }
    public function getTokenPassword(){
         
        return $this->attributes['tokenPassword'];
    }
    public function getuseremail(){
         
        return $this->attributes['useremail'];
    }
    public function getUserTel(){
         
        return $this->attributes['usertel'];
    }
    public function getuseradress(){
         
        return $this->attributes['useradress'];
    }
    public function getuserBirthday(){
         
        return $this->attributes['userBirthday'];
    }
    public function getuserDni(){
         
        return $this->attributes['dniUsuario'];
    }
    
    public function obtenerEmail(string $email)
    {
        $model= model('UserModel');
        return $model->where('useremail',$email)->first();
    }
    public function obtenerUser(string $id)
    {
        $model= model('UserModel');
        return $model->where('id_user',$id)->first();
    }
    public function getRole()
    {
        $model= model('GroupModel');
        return $model->where('id_group',$this->id_group)->first();
    }
}