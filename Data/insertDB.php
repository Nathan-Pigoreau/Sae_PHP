<?php
try{
    require 'Classes/Provider/DataLoaderYml.php';
    $dataLoaderYml = new \Provider\DataLoaderYml();
    echo($dataLoaderYml->loadData('Data\extrait.yml'));

} catch (\Exception $e) {
    echo "Erreur : " . $e->getMessage();
}
