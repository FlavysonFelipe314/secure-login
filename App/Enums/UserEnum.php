<?php

namespace App\Enums;

enum UserEnum : string {
    case ADMIN = "admin";
    case MODERATOR = "moderador";
    case DEVELOPER = "developer";
    case USER = "user";
}