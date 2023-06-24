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

// Extraire l'action à partir de l'URL
$actionParts = explode('/', $action);
$action = $actionParts[0];

var_dump($action);
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
        //verification de parametre de requete
         if (count($actionParts) > 1) {
            if ($actionParts[1]== 'deletePoke')
            $id = $actionParts[2];
            // Appeler la méthode deletePoke avec l'identifiant
            $pokeController->deletePoke($id);

        } 
        //si pas action affichage du dashboard
        else {
            $pokeController->displayPoke();
        }
       
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
