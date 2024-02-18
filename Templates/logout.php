<?php

declare(strict_types=1);

namespace Templates;

session_start(); 

if(isset($_SESSION['user'])) {
    session_unset();
    session_destroy();
    header('Location: /');
    exit(); 
} else {
    header('Location: /login.php');
    exit(); 
}
