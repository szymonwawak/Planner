<?php

namespace App\Controllers;

use App\Controllers\Api\Utils;

class Controller extends Utils
{
    protected $container;

    public function __construct($container)
    {
        $this->container = $container;
    }


}