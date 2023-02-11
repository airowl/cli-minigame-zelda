<?php

namespace DemoGame\Zelda\Item;

class Item
{
    public $name;

    public function __construct($name = null)
    {
        $this->name = $name;
    }

}