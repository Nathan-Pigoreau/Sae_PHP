<?php
try{
    require 'Classes/Provider/DataLoaderYml.php';
    $dataLoaderYml = new \Provider\DataLoaderYml();
    echo($dataLoaderYml->loadData('Data\extrait.yml'));
    require 'Classes/Modele/ModeleDB/UtilisateurDB.php';
    $utilisateurDB = new \Modele\ModeleDB\UtilisateurDB();
    $utilisateurDB->addAdmin();
    echo("\n Admin ajouté");

} catch (\Exception $e) {
    echo "Erreur : " . $e->getMessage();
}
