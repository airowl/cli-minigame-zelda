<?php

namespace DemoGame\Zelda\Characters;

use DemoGame\Zelda\Characters\Character;

class Hero
{
    public $name;
    public $actualCoor;
    public $bag = [];

    public function __construct($name, $actualCoor, $bag = [])
    {
        $this->name = $name;
        $this->actualCoor = $actualCoor;
        $this->bag = $bag;
    }

    // method
    public function move($direction)
    {
        switch ($direction) {
            case 'north':
                print 'go north';
                break;
            case 'south':
                print 'go south';
                break;
            case 'est':
                print 'go est';
                break;
            case 'west':
                print 'go west';
                break;
            default:
                print 'direction not found';
        }
    }

        
    /**
     * updateCoor
     *
     * @param  mixed $axis
     * @param  mixed $dir
     * @return void
     */
    public function updateCoor($axis, $dir)
    {
        if ($axis == 'x') {
            if ($dir == 'left') {
                $this->actualCoor->x = $this->actualCoor->x - 1;
                return 'sei andato a sinistra';
            }
            if ($dir == 'right') {
                $this->actualCoor->x = $this->actualCoor->x + 1;
                return 'sei andato a destra';
            }
        } 

        if ($axis == 'y') {
            if ($dir == 'up') {
                $this->actualCoor->y = $this->actualCoor->y - 1;
                return 'sei andato su';
            }
            if ($dir == 'down') {
                $this->actualCoor->y = $this->actualCoor->y + 1;
                return 'sei andato giu';
            }
        }
        
    }

    
    /**
     * pickItem
     *
     * @param  mixed $item
     * @return void
     */
    public function pickItem($item)
    {
        $this->bag[] = $item;
    }
        
    /**
     * dropItem
     *
     * @return void
     */
    public function dropItem()
    {
        $count = count($this->bag);
        $itemDropped = $this->bag[$count - 1];
        unset($this->bag[$count - 1]);
        return $itemDropped;
    }
    
    /**
     * attack
     *
     * @param  mixed $weaknessMonster
     * @return void
     */
    public function attack($weaknessMonster)
    {
        foreach($this->bag as $item){
            if($item->name == $weaknessMonster){
                return true;
                break;
            }
        }
        return false;
    }

}