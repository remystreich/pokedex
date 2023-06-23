<?php
require_once './src/services/Validator.php';

class PokeController
{
    private $pokeRepository;
    public $errors = array();

    public function __construct()
    {
        $this->pokeRepository = new PokeRepository();
    }

    public function catch($data)
    {

        $apiUrl = 'https://pokebuildapi.fr/api/v1/pokemon/' . $data['pokemon'];

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

            $imgUrl = $result['image'];
            $fileName = uniqid() . '.png';
            $uploadDirectory = './assets/uploads/';
            $filePath = $uploadDirectory . $fileName;

            // Télécharger l'image du Pokémon et l'enregistrer localement
            $imageData = file_get_contents($imgUrl);
            if ($imageData === false) {
                throw new Exception('Erreur lors du téléchargement de l\'image');
            }
            file_put_contents($filePath, $imageData);

            // Créer un objet PokeModel avec les données du Pokémon
            $pokemon = new PokeModel($result['name'], $result['apiTypes'][0]['name'], $_SESSION['userId'], $filePath);

            // Enregistrer le Pokémon dans la base de données
            $pokemon = $this->pokeRepository->save($pokemon);

            header('Location: /pokedex/index.php/catchPoke');
        } catch (Exception $e) {
            // Gérer les exceptions
            include_once './views/catchPoke.php';
        }
    }
}
