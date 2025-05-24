<?php

namespace App\Repository;

use App\Core\Repository;
use App\Interfaces\UserInterface;
use App\Models\User;
use PDO;

class UserRepository extends Repository implements UserInterface{

    public function create(User $user)
    {
        $sql = $this->pdo->prepare("INSERT INTO users
        (name, email, password, access, avatar, token) VALUES
        (:name, :email, :password, :access, :avatar, :token)");

        $sql->bindValue(":name", $user->getName());
        $sql->bindValue(":email", $user->getEmail());
        $sql->bindValue(":password", $user->getPassword());
        $sql->bindValue(":access", $user->getAccess()->value);
        $sql->bindValue(":avatar", $user->getAvatar());
        $sql->bindValue(":token", $user->getToken());

        $sql->execute();
    }

    public function update(User $user)
    {
        $sql = $this->pdo->prepare("UPDATE users SET
            name = :name,
            email = :email,
            password = :password,
            access = :access,
            avatar = :avatar,
            token = :token
        WHERE id = :id");

        $sql->bindValue(":name", $user->getName());
        $sql->bindValue(":email", $user->getEmail());
        $sql->bindValue(":password", $user->getPassword());
        $sql->bindValue(":access", $user->getAccess());
        $sql->bindValue(":avatar", $user->getAvatar());
        $sql->bindValue(":token", $user->getToken());

        $sql->bindValue(":id", $user->getId());

        $sql->execute();
    }

    public function verifyAccount(User $user)
    {
        $sql = $this->pdo->prepare("UPDATE users SET
            is_verified = :is_verified
        WHERE email = :email");

        $sql->bindValue(":is_verified", $user->getIsVerified());
        $sql->bindValue(":email", $user->getEmail());
        $sql->execute();
    }

    public function delete($id)
    {
        $sql = $this->pdo->prepare("DELETE FROM users WHERE id = :id");
        $sql->bindValue(":id", $id);
        $sql->execute();
    }
    
    public function findAll()
    {
        $sql = $this->pdo->prepare("SELECT * FROM users 
        ORDER BY id DESC");
        $sql->execute();

        if($sql->rowCount() > 0){
            $data = $sql->fetchAll();
            
            $array = [];

            foreach($data as $item){
                $array[] = $this->_generateUser($item);
            }

            return $array;
        }

        return false;
    }

    public function findBy($key, $value)
    {
        $sql = $this->pdo->prepare("SELECT * FROM users WHERE $key = :$key");
        $sql->bindValue(":$key", $value);
        $sql->execute();

        if($sql->rowCount() > 0){
            $data = $sql->fetch(PDO::FETCH_ASSOC);

            if($user = $this->_generateUser($data)){
                return $user;
            }

        }else{
            return false;
        }
    }

    public function findAllBy($key, $value)
    {
        $sql = $this->pdo->prepare("SELECT * FROM users 
        WHERE $key = :$key 
        ORDER BY id DESC");
        $sql->bindValue(":$key", $value);
        $sql->execute();

        if($sql->rowCount() > 0){
            $data = $sql->fetchAll();
            
            $array = [];

            foreach($data as $item){
                $array[] = $this->_generateUser($item);
            }

            return $array;
        }

        return false;
    }

    private function _generateUser($data)
    {
        $User = new User;
        $User->setId($data["id"]);
        $User->setName($data["name"]);
        $User->setEmail($data["email"]);
        $User->setPassword($data["password"]);
        $User->setAccess($data["access"]);
        $User->setAvatar($data["avatar"]);
        $User->setToken($data["token"]);
        $User->setIsVerified($data["is_verified"]);
        
        return $User;
    }

}