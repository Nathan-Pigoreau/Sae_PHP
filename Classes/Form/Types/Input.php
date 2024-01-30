<?php
declare (strict_types=1);

namespace Classes\Form\Types;

use Classes\Form\Types\Irender;

require_once(__DIR__ . '/Irender.php');

abstract class Input implements Irender{
    private string $name;
    private mixed $id;
    private string $type;
    private string $value;

    public function __construct(string $name, mixed $id, string $type, string $value){
        $this->name = $name;
        $this->id = $id;
        $this->type = $type;
        $this->value = $value;
    }

    /**
     * Retourne le nom de l'input
     */
    public function __toString() : string
    {
        return $this->render();
    }


    /**
     * Retourne le nom de l'input
     */
    public function render(): string
    {
    $value = $this->value ? 'value="'.$this->value.'"' : '';
    

    $input = sprintf(
        '<input type="%s" name="%s" id="%s" %s %s>', 
        htmlspecialchars(strval($this->type)), // htmlspecialchars() permet de convertir les caractères spéciaux en entités HTML
        htmlspecialchars(strval($this->name)),
        htmlspecialchars(strval($this->id)),
        $value
    );
    return $input; // Retourne l'input
    }
    
    
}

?>

