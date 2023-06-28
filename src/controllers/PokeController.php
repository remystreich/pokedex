<?php


class PokeController
{
    private $pokeRepository;
    public $errors = array();

    public function __construct()
    {
        $this->pokeRepository = new PokeRepository();
    }

    private function fetchAPI($data)
    {
        $apiUrl = 'https://pokebuildapi.fr/api/v1/pokemon/' . $data;
        try {
            // Effectuer la requête Fetch
            $response = file_get_contents($apiUrl);

            // Vérifier si la requête a réussi
            if ($response === false) {
                throw new Exception('Impossible de trouver ce pokémon');
            }

            // Convertir la réponse JSON en tableau associatif
            $result = json_decode($response, true);

            // Vérifier si la conversion JSON a réussi
            if ($result === null) {
                throw new Exception('Erreur de conversion JSON');
            }
            return $result;
        } catch (Exception $e) {
            // Gérer les exceptions
            include_once './views/catchPoke.php';
        }
    }

    public function catch($data)
    {
        try {
            //récupérer les données du pokemon 
            $result = $this->fetchAPI($data);
            $image = $result['image'];


            // Télécharger l'image du Pokémon et l'enregistrer localement
            $imageData = file_get_contents($image);
            if ($imageData === false) {
                throw new Exception('Erreur lors du téléchargement de l\'image');
            }

            //traiter les données de l'image
            $imageInfo = getimagesizefromstring($imageData);

            //récupération de l'extension de l'image, lui donner un nom et son fichier d'enregistrement
            $type = explode('/', $imageInfo['mime'])[1];
            $fileName = uniqid() .'.'. $type;
            
            $uploadDirectory = './assets/uploads/' . $fileName;

            // Créer un objet PokeModel avec les données du Pokémon
            $pokemon = new PokeModel($result['name'], $result['apiTypes'][0]['name'], $_SESSION['userId'], $imageInfo, $result['pokedexId']);

            //validation des données
            $validator = new PokeValidator($pokemon);
            $errors =  $validator->validatePokemon();
            if ($errors) {
                throw new Exception('Format d\'image invalide');
            }

            //chemin à enregistrer en bdd, et modification de l'objet en instance
            $filePathDb = 'uploads/' . $fileName;
            $pokemon->setImage($filePathDb);

           

            //enregistrer l'image dans le dossier upload
            file_put_contents($uploadDirectory, $imageData);

            // Enregistrer le Pokémon dans la base de données
            $pokemon = $this->pokeRepository->save($pokemon);
            $success = "Pokémon attrapé !";
            include_once './views/catchPoke.php';
        } catch (Exception $e) {
            // Gérer les exceptions
            include_once './views/catchPoke.php';
        }
    }

    //fonction pour afficher tous les pokemons
    public function displayPoke()
    {
        $pokemons = $this->pokeRepository->getPokemons();
        include_once './views/dashboard.php';
    }

    public function deletePoke($id)
    {
        $this->pokeRepository->delete($id);
        $this->displayPoke();
    }

    //evoluer pokemon
    public function evoPoke($id, $pokedexId)
    {
        try {
            //Chercher l'evolution du pokemon
            $result = $this->fetchAPI($pokedexId);
            var_dump('uzeo');
            
            //Si pas d'evolution
            if (count($result['apiEvolutions']) == 0) {
                
                throw new Exception('Ce pokémon ne peut pas évoluer');
                
            }
            
            //récupérer l'evolution du pokemon
            $evolution = $this->fetchAPI($result['apiEvolutions'][0]['pokedexId']);



            // Récupérer les infos de l'image
            $image = $evolution['image'];
            $imageData = file_get_contents($image);
            if ($imageData === false) {
                throw new Exception('Erreur lors du téléchargement de l\'image');
            }
            $imageInfo = getimagesizefromstring($imageData);

            //récupération de l'extension de l'image, lui donner un nom et son fichier d'enregistrement
            $type = explode('/', $imageInfo['mime'])[1];
            $fileName = uniqid() . $type;
            $uploadDirectory = './assets/uploads/' . $fileName;

            // Créer un objet PokeModel avec les données du Pokémon
            $evolution = new PokeModel($evolution['name'], $evolution['apiTypes'][0]['name'], $_SESSION['userId'], $imageInfo, $evolution['pokedexId']);

            //validation des données
            $validator = new PokeValidator($evolution);
            $errors =  $validator->validatePokemon();
            if ($errors) {
                throw new Exception('Format d\'image invalide');
            }

            //chemin à enregistrer en bdd, et modification de l'objet en instance
            $filePathDb = 'uploads/' . $fileName;
            $evolution->setImage($filePathDb);


            //enregistrer l'image dans le dossier upload
            file_put_contents($uploadDirectory, $imageData);


            // Mettre à jour le pokemon
            $evolution = $this->pokeRepository->update($id, $evolution);
            $this->displayPoke();
        } catch (Exception $e) {
            $pokemons = $this->pokeRepository->getPokemons();
            include_once './views/dashboard.php';
        }
    }


    public function updatePoke($id, $data)
    {
        //récupérer les infos de l'image
        $image = $_FILES['image'];

        if ($image['size'] !== 0) {
            
            $imageData = file_get_contents($image['tmp_name']);
            $imageInfo = getimagesize($image['tmp_name']);

            //donner un nom et un chemin à l'image
            $type = explode('/', $image['type'])[1];
            $fileName = uniqid() . $type;
            $uploadDirectory = './assets/uploads/' . $fileName;
        }


        //créer objet upload à partir d'une instance de PokeModel
        $update = new PokeModel($data['name'], $data['type'], $_SESSION['userId'], $imageInfo);

        $validator = new PokeValidator($update);
        $errors =  $validator->validatePokemon();

        if ($errors) {
            $version = 'pokemon';
            include_once './views/update.php';
        } else {
            //si pas d'erreurs de formulaire
            if ($image['size'] !== 0) {
                //enregistrement de l'image
                file_put_contents($uploadDirectory, $imageData);

                //setter le chemin à enregistrer en bdd
                $filePathDb = 'uploads/' . $fileName;
                $update->setImage($filePathDb);
            }


            // Enregistrer le Pokémon dans la base de données
            $update = $this->pokeRepository->update($id, $update);

            header("Location:  " . Config::$absolutepath . "/dashboard");
        }
    }
}
