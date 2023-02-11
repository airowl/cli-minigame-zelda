<?php

namespace DemoGame\Zelda\Characters;

use DemoGame\Zelda\Characters\Character;

class Monster
{
    public $name;
    public $isDie;
    public $weakness;

    public function __construct($name = null, $isDie = false, $weakness)
    {
        $this->name = $name;
        $this->isDie = $isDie;
        $this->weakness = $weakness;
    }

    // method
    public function kill()
    {
        $this->isDie = true;
    }

}