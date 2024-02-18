<?php

declare (strict_types=1);

namespace Classes\Form\Types;

use Classes\Form\Types\Input;

require_once(__DIR__ . '/Input.php');

class InputPassword extends Input
{
    public function __construct(mixed $name, mixed $id, string $value)
    {
        // Pour le password
        parent::__construct($name, $id, 'password', $value);
    }
}

?>