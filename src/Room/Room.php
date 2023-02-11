<?php

namespace DemoGame\Zelda\Room;

class Room
{
    //public $northPart;
    //public $southPart;
    //public $estPart;
    //public $westPart;

    //public function __construct($northPart = null, $southPart = null, $estPart = null, $westPart = null)
    //{
    //    $this->northPart = $northPart;
    //    $this->northPart = $southPart;
    //    $this->northPart = $estPart;
    //    $this->northPart = $westPart;
    //}

    // metodo del room
    //TODO creare funzione di check della stanza attuale
    public function checkActualRoom($actualCoor, $rooms)
    {
        foreach($rooms as $room){
            if($actualCoor->x === $room->coor->x && $actualCoor->y === $room->coor->y){
                return $room;
                break;
            }
        }
    }

    //TODO check se la via è libera
    public function checkFreeWay($directions, $part)
    {
        foreach ($directions as $alias => $dir){
            if($alias == $part){
                if($dir == true){
                    return true;
                    break;
                } else {
                    return false;
                    break;
                }
            }
        }
    }

    //TODO check le vie libere
    public function checkFreeWays($directions)
    {
        $res = array();
        foreach($directions as $i => $dir){
            if (!$dir == false) {
                $res[$i] = $i;
            }
        }
        return $res;
    }

    //TODO checkItem

    //TODO check monster

    //TODO print della stanza
    public function printDetailsRoom($room)
    {
        $details = array();
        $details['passRoom'] = sprintf('Sei riuscito a passare nella stanza %s. ', $room->nRoom);
        $details['descriptionRoom'] = $room->description;
        $details['freeWays'] = self::checkFreeWays($room->directions);

        return $details;
    }

    //TODO unlock way
    public function unlockWay($directions)
    {
        foreach($directions as $alias => $dir){
            if($alias == 'southPart'){
                var_dump($alias);
                var_dump($dir);
                $dir = true;
                break;
            }
        }
    }
}