<?php

namespace App\Core;

use \DantSu\PHPImageEditor\Image;

class Controller
{
    public function loadView($viewName, $viewData = [])
    {
        extract($viewData);
        require_once __DIR__ . "/../../Views/".$viewName.".php";
    } 
                                                                                           
    public function loadTemplate($viewName, $viewData = [])
    {
        require_once __DIR__ . "/../../Views/template.php";
    }

    public function loadViewTemplate($viewName, $viewData = [])
    {
        extract($viewData);
        require_once __DIR__ .  "/../../Views/".$viewName.".php";
    }

    public function loadFlash($message)
    {
        $_SESSION["flash"] = "<div class='alertMessage'>".$message."</div>";
    } 

    public function getFlashMessage()
    {
        if(!empty($_SESSION["flash"]))
        {
            
            echo $_SESSION["flash"];
    
            $_SESSION["flash"] = "";
        }
    }

    public function saveImage($width, $height, $urlSend, $path)
    {
        $image = Image::fromPath($path)
        ->crop($width, $height, Image::ALIGN_CENTER, Image::ALIGN_MIDDLE)
        ->resize($width,$height)
        ->savePNG($urlSend);
    }

}
?>