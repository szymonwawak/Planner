<?php

namespace App\Controllers;

use App\Controllers\Api\Utility;

class Controller extends  Utility
{
    protected $container;

    public function __construct($container)
    {

        $this->container = $container;

    }


}