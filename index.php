<?php
session_start();

require './src/controllers/UserController.php';
require './src/repositories/UserRepository.php';
require './src/models/UserModel.php';
require './src/services/Form.php';
require './src/controllers/PokeController.php';
require './src/models/PokeModel.php';
require './src/repositories/PokeRepository.php';

$userController = new UserController();
$pokeController = new PokeController();

$action = isset($_SERVER['REQUEST_URI']) ? (substr($_SERVER['REQUEST_URI'], 19)) : '';
switch ($action) {

    case 'register':
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $userController->register($_POST);
        }
        include_once('./views/register.php');
        break;

    case 'login':
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $userController->login($_POST);
        }
        include_once('./views/login.php');
        break;

    case 'dashboard':
        include_once('./views/dashboard.php');
        break;
    
        case 'catchPoke':
            if ($_SERVER['REQUEST_METHOD'] == 'POST') {
                $pokeController->catch($_POST);
            }
            include_once('./views/catchPoke.php');
            break;


    default:
        # code...
        break;
    
    
}
