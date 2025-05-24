<?php

use Dotenv\Dotenv;

session_name("user_session");
session_set_cookie_params([
    'secure'=> false,
    'httponly'=> true,
    'samesite'=> 'Lax',
]);
session_start();

date_default_timezone_set("America/Sao_Paulo");

require_once "./vendor/autoload.php";

$path = __DIR__ . DIRECTORY_SEPARATOR . '..';
$dotenv = Dotenv::createUnsafeImmutable($path);
$dotenv->load();

define("SYSTEM_MODE", $_ENV["SYSTEM_MODE"]);

if(SYSTEM_MODE == "development"){
    ini_set("display_errors", "On");
    error_reporting(E_ALL);
}

define("SYSTEM_NAME", $_ENV["SYSTEM_NAME"]);

define("DB_HOST", $_ENV["DB_HOST"]);
define("DB_NAME", $_ENV["DB_NAME"]);
define("DB_USER", $_ENV["DB_USER"]);
define("DB_PASSWORD", $_ENV["DB_PASSWORD"]);

define("BASE_DIR", $_ENV["BASE_DIR"]);

define("CSRF_SESSION_KEY", $_ENV["CSRF_SESSION_KEY"]);
define("CSRF_TTL", $_ENV["CSRF_TTL"]);
define("CSRF_LENGTH", $_ENV["CSRF_LENGTH"]);

define("MAIL_ADDRESS", $_ENV["MAIL_ADDRESS"]);
define("MAIL_PASSWORD_KEY", $_ENV["MAIL_PASSWORD_KEY"]);
define("MAIL_HOST", $_ENV["MAIL_HOST"]);
define("MAIL_PORT", $_ENV["MAIL_PORT"]);
define("MAIL_SMTP_DEBUG", $_ENV["MAIL_SMTP_DEBUG"]);
define("MAIL_SMTP_AUTH", $_ENV["MAIL_SMTP_AUTH"]);

ini_set("log_errors", "On");
ini_set("error_log", BASE_DIR . "/Logs/System.log");

require_once "Database.php";

?>
