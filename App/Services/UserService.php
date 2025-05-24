<?php

namespace App\Services;

use App\Enums\UserEnum;
use App\Exceptions\InvalidCredentialsException;
use App\Models\User;
use App\Repository\UserRepository;
use Exception;

class UserService{
    
    private $UserRepository;

    public function __construct()
    {
        $this->UserRepository = new UserRepository;
    }

    public function create($name, $email, $password)
    {
        $token = bin2hex(random_bytes(64));
        $access = UserEnum::ADMIN;
        $passwordHash = password_hash($password, PASSWORD_BCRYPT);
        $avatar = "default_avatar.png";
        
        $User = new User;
        $User->setName($name);
        $User->setEmail($email);
        $User->setPassword($passwordHash);
        $User->setToken($token);
        $User->setAccess($access);
        $User->setAvatar($avatar);

        try{
            if($this->UserRepository->create($User)){
                return true;
            }
        } catch (Exception $err){
            echo $err;
        }
    }

    public function authenticate($email, $password)
    {
        $user = $this->findBy("email", $email);


        if(empty($user) || !(password_verify($password, $user->getPassword()))){
            throw new InvalidCredentialsException();    
        }

        try{
            $token = bin2hex(random_bytes(32));

            $user->setToken($token);
            
            $this->UserRepository->update($user);
        
            $_SESSION["token"] = $token;
        
            session_regenerate_id(true);
        
        } catch (Exception $err){
            return $err->getMessage();
        }

        return $user;
    }

    public function findAll()
    {
        $data = $this->UserRepository->findAll();
        return $data;
    }

    public function findBy($key, $value)
    {
        $data = $this->UserRepository->findBy($key, $value);
        return $data;
    }

    public function findAllBy($key, $value)
    {
        $data = $this->UserRepository->findAllBy($key, $value);
        return $data;
    }

    public function update($name, $email, $password, $access, $id)
    {
        $User = $this->UserRepository->findBy("id", $id);
        if($User){
            try{
                $hash = password_hash($password, PASSWORD_BCRYPT);

                $User->setName($name);
                $User->setEmail($email);
                $User->setPassword($hash);
                $User->setAccess($access);

                $this->UserRepository->update($User);
            } catch(Exception $err){
                echo "Algo deu Errado: $err";
            }
        }  else{
            return false;
        }
    }

    public static function verifyAccount(User $user)
    {
        $UserRepository = new UserRepository;
        $data = $UserRepository->verifyAccount($user);
        return $data;
    }

    public function delete($id)
    {
        $this->UserRepository->delete($id);
        return true;
    }

}