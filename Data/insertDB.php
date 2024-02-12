<?php
try{
    require 'Classes/Provider/DataLoaderYml.php';
    $dataLoaderYml = new \Classes\Provider\DataLoaderYml();
    echo($dataLoaderYml->loadData('Data\extrait.yml'));

} catch (\Exception $e) {
    echo "Erreur : " . $e->getMessage();
}
