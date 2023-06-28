<?php
session_start();
require_once './config.php';
require './src/controllers/UserController.php';
require './src/repositories/UserRepository.php';
require './src/models/UserModel.php';
require './src/services/Form.php';
require './src/controllers/PokeController.php';
require './src/models/PokeModel.php';
require './src/repositories/PokeRepository.php';
require './src/validators/userValidators.php';
require './src/validators/pokeValidators.php';

$userController = new UserController();
$pokeController = new PokeController();
$pokeRepository = new PokeRepository();
$userRepository = new UserRepository();


$actionParts = isset($_SERVER['REQUEST_URI']) ? (str_replace(Config::$dirPath, '', $_SERVER['REQUEST_URI'])) : '';

// Extraire l'action à partir de l'URL

$action = explode('/' , $actionParts);




switch ($action[0]) {

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
        $userController->authGuard();
        //verification de parametre de requete
        if (count($action) > 0) {
            $id = $action[2];
            if ($action[1] == 'deletePoke') {
                // Appeler la méthode deletePoke avec l'identifiant
                $pokeController->deletePoke($id);
            } else if ($action[1] == 'evoPoke') {
                
                $pokedexId = $action[3];
                $pokeController->evoPoke($id, $pokedexId);
            } else {
                $pokeController->displayPoke();
            }

            //si pas action affichage du dashboard
        } else {
            $pokeController->displayPoke();
        }

        break;

    case 'catchPoke':
        $userController->authGuard();
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $pokeController->catch($_POST['pokemon']);
        }
        include_once('./views/catchPoke.php');
        break;

    case 'updatePoke':
        $userController->authGuard();
        $version = 'pokemon';
        $id = $action[1];
        $data = $pokeRepository->getPokemon($id);
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $pokeController->updatePoke($id, $_POST);
        }
        include_once('./views/update.php');
        break;

    case 'logout':
        session_destroy();
        header("Location:  " . Config::$absolutepath . "/login");
        break;

    case 'updateUser':
        $userController->authGuard();
        $version = 'user';
        $data = $userRepository->getUser($_SESSION['userId']);
        
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $userController->updateUser($_POST);
        }
        include_once('./views/update.php');
        break;

    default:
        
        break;
}
