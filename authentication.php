<?php

session_start();

$_SESSION['last_page'] = $_SERVER['REQUEST_URI']; 

if(!isset($_SESSION['auth']))
{
    $_SESSION['message'] = "Login first! To access the site";
    header("location: index.php");
    die();
}

