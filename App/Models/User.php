<?php

namespace App\Models;

class User{
    private $id;
    private $name;
    private $email;
    private $password;
    private $access;
    private $avatar;
    private $token;
    private $is_verified;
    private $created_at;
    private $updated_at;

    // Getters
    public function getId() {
        return $this->id;
    }

    public function getName() {
        return $this->name;
    }

    public function getEmail() {
        return $this->email;
    }

    public function getPassword() {
        return $this->password;
    }

    public function getAccess() {
        return $this->access;
    }

    public function getAvatar() {
        return $this->avatar;
    }

    public function getToken() {
        return $this->token;
    }

    public function getIsVerified() {
        return $this->is_verified;
    }

    public function getCreatedAt() {
        return $this->created_at;
    }

    public function getUpdatedAt() {
        return $this->updated_at;
    }

    // Setters
    public function setId($id) {
        $this->id = $id;
    }

    public function setName($name) {
        $this->name = $name;
    }

    public function setEmail($email) {
        $this->email = $email;
    }

    public function setPassword($password) {
        $this->password = $password;
    }

    public function setAccess($access) {
        $this->access = $access;
    }

    public function setAvatar($avatar) {
        $this->avatar = $avatar;
    }

    public function setToken($token) {
        $this->token = $token;
    }

    public function setIsVerified($is_verified) {
        $this->is_verified = $is_verified;
    }

    public function setCreatedAt($created_at) {
        $this->created_at = $created_at;
    }

    public function setUpdatedAt($updated_at) {
        $this->updated_at = $updated_at;
    }
}