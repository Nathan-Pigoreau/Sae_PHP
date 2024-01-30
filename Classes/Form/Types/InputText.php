<?php

declare(strict_types= 1);

namespace Classes\Form\Types;

use Classes\Form\Types\Input;

require_once(__DIR__ . '/Input.php');

class InputText extends Input
{
    public function __construct(string $name, mixed $id, string $value)
    {   
        // Pour le text
        parent::__construct($name, $id, 'text', $value);
    }


}
?>