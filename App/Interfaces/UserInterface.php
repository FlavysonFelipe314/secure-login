<?php

namespace App\Interfaces;

use App\Models\User;

interface UserInterface{
    public function create(User $user);
    public function update(User $user);
    public function delete($id);
    public function findAll();
    public function findBy($key, $value);
    public function findAllBy($key, $value);
}