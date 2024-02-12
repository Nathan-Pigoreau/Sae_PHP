<?php
declare(strict_types=1);

namespace Classes;

require_once 'Classes/Debug/dd.php';

/**
 * Class Autoloader
 */
class Autoloader{
    /**
     * Enregistre notre autoloader
     */
    static function register(){
        spl_autoload_register(array(__CLASS__, 'autoload'));
    }

    /**
     * Inclue le fichier correspondant à notre classe
     * @param $class string Le nom de la classe à charger
     */
    static function autoload($fqcn){
        $path = str_replace('\\', '/', $fqcn);
        require 'Classes/' . $path . '.php';
    }
}