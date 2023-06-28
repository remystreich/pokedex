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

$actionParts = isset($_SERVER['REQUEST_URI']) ? (explode('/', $_SERVER['REQUEST_URI'])) : '';

// Extraire l'action à partir de l'URL

$action = $actionParts[2];



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
        $userController->authGuard();
        //verification de parametre de requete
        if (count($actionParts) > 3) {
            $id = $actionParts[4];
            if ($actionParts[3] == 'deletePoke') {
                // Appeler la méthode deletePoke avec l'identifiant
                $pokeController->deletePoke($id);
            } else if ($actionParts[3] == 'evoPoke') {
                
                $pokedexId = $actionParts[5];
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
        $id = $actionParts[3];
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
        # code...
        break;
}
