<?php

namespace DemoGame\Zelda\Commands;

use DemoGame\Zelda\Characters\Hero;
use DemoGame\Zelda\Room\Room;
use DemoGame\Zelda\Characters\Monster;
use DemoGame\Zelda\Item\Item;
use DemoGame\Zelda\ReadFile\Read;

class Play
{
    public $command;

    public function __construct($command)
    {
        $this->command = $command;
    }

    public function run()
    {
        // creare un array di stanze
        $rooms = array(
            (object) [
                'nRoom' => '1',
                'directions' => (object) [
                    'northPart' => false,
                    'southPart' => true,
                    'estPart' => true,
                    'westPart' => false,
                ],
                'isEmpty' => true,
                'coor' => (object)[
                    'x' => 1,
                    'y' => 1,
                ],
            ],
            (object) [
                'nRoom' => '2',
                'directions' => (object) [
                    'northPart' => false,
                    'southPart' => true,
                    'estPart' => true,
                    'westPart' => true,
                ],
                'item' => new Item('Pepita'),
                'coor' => (object)[
                    'x' => 2,
                    'y' => 1,
                ],
            ],
            (object) [
                'nRoom' => '3',
                'directions' => (object) [
                    'northPart' => false,
                    'southPart' => false,
                    'estPart' => false,
                    'westPart' => true,
                ],
                'item' => new Item('Scudo magico'),
                'coor' => (object)[
                    'x' => 3,
                    'y' => 1,
                ],
            ],
            (object) [
                'nRoom' => '4',
                'directions' => (object) [
                    'northPart' => true,
                    'southPart' => false,
                    'estPart' => false,
                    'westPart' => false,
                ],
                'item' => new Item('Calice'),
                'coor' => (object)[
                    'x' => 1,
                    'y' => 2,
                ],
            ],
            (object) [
                'nRoom' => '5',
                'directions' => (object) [
                    'northPart' => true,
                    'southPart' => true,
                    'estPart' => true,
                    'westPart' => false,
                ],
                'monster' => new Monster('Medusa', false, 'Scudo magico'),
                'coor' => (object)[
                    'x' => 2,
                    'y' => 2,
                ],
            ],
            (object) [
                'nRoom' => '6',
                'directions' => (object) [
                    'northPart' => false,
                    'southPart' => true,
                    'estPart' => false,
                    'westPart' => true,
                ],
                'monster' => new Monster('Vampiro', false, 'Pugnale'),
                'coor' => (object)[
                    'x' => 3,
                    'y' => 2,
                ],
            ],
            (object) [
                'nRoom' => '7',
                'directions' => (object) [
                    'northPart' => false,
                    'southPart' => false,
                    'estPart' => true,
                    'westPart' => false,
                ],
                'item' => new Item('Pugnale'),
                'coor' => (object)[
                    'x' => 1,
                    'y' => 3,
                ],
            ],
            (object) [
                'nRoom' => '8',
                'directions' => (object) [
                    'northPart' => true,
                    'southPart' => false,
                    'estPart' => false,
                    'westPart' => true,
                ],
                'item' => new Item('Pergamena'),
                'coor' => (object)[
                    'x' => 2,
                    'y' => 3,
                ],
            ],
            (object) [
                'nRoom' => '9',
                'directions' => (object) [
                    'northPart' => true,
                    'southPart' => false,
                    'estPart' => false,
                    'westPart' => false,
                ],
                'coor' => (object)[
                    'x' => 3,
                    'y' => 3,
                ],
            ],
        );

        $actualCoor = (object)[
            'x' => 1,
            'y' => 1,
        ];

        
        $read = new Read();
        $x = $read->divideTxt('Rooms');

        for ($i = 0; $i < count($rooms); $i++) {
            $rooms[$i]->description = $x[$i]; 
        }

        $hero = new Hero('Amico', $actualCoor);

        do {
            $cmd = trim(strtolower( readline("\n> Enter command: ") ));
            readline_add_history($cmd);

            switch (strtolower($cmd)) {
                case 'move north':
                    $part = 'northPart';
                    $room = Room::checkActualRoom($hero->actualCoor, $rooms);

                    if (Room::checkFreeWay($room->directions, $part)) {

                        if(!isset($room->monster) || $room->monster->isDie){
                            print "via libera \n";
                            $way = $hero->updateCoor('y', 'up');
                            print $way . "\n";

                            $room = Room::checkActualRoom($hero->actualCoor, $rooms);

                            if ($room->nRoom == '9') {
                                $read = new Read('EndWin.txt');
                                print $read->read();
                                exit();
                            } else {
                                $detailsRoom = Room::printDetailsRoom($room);
                                foreach($detailsRoom as $alias => $detail){
                                    if (!is_array($detail)) {
                                        print $detail . "\n";
                                    } else {
                                        if ($alias == 'freeWays') {
                                            print "Puoi passare in queste vie: \n";
                                            foreach($detail as $way){
                                                print $way . "\n";
                                            }
                                        }
                                    }
                                }
                            }

                            //TODO visualizzare l'item nel room
                            if (isset($room->item)) {
                                print "In questa stanza c'è un item: " . $room->item->name . "\n";
                            } else{
                                print "In questa stanza non ci sono item" . "\n";
                            }

                            //TODO visualizzare il mostro
                            if (!$room->monster->isDie && isset($room->monster)) {
                                print "In questa stanza c'è un mostro: " . $room->monster->name . "\n";
                            } else{
                                print "In questa stanza non ci sono mostri" . "\n";
                            }
                            break;
                        } else{
                            print "Via bloccata uccidi prima il mostro \n";
                        }

                    } else {
                        print "via bloccata \n";
                        print sprintf('Sei ancora nella stanza %s', $room->nRoom);
                    }

                    break;
                case 'move south':
                    $part = 'southPart';

                    $room = Room::checkActualRoom($hero->actualCoor, $rooms);

                    if (Room::checkFreeWay($room->directions, $part)) {

                        if(!isset($room->monster) || $room->monster->isDie){
                            print "via libera \n";
                            $way = $hero->updateCoor('y', 'down');
                            print $way . "\n";
    
                            $room = Room::checkActualRoom($hero->actualCoor, $rooms);

                            if ($room->nRoom == '9') {
                                $read = new Read('EndWin.txt');
                                print $read->read();
                                exit();
                            } else {
                                $detailsRoom = Room::printDetailsRoom($room);
                                foreach($detailsRoom as $alias => $detail){
                                    if (!is_array($detail)) {
                                        print $detail . "\n";
                                    } else {
                                        if ($alias == 'freeWays') {
                                            print "Puoi passare in queste vie: \n";
                                            foreach($detail as $way){
                                                print $way . "\n";
                                            }
                                        }
                                    }
                                }
                            }
    
                            //TODO visualizzare l'item nel room
                            if (isset($room->item)) {
                                print "In questa stanza c'è un item: " . $room->item->name . "\n";
                            } else{
                                print "In questa stanza non ci sono item" . "\n";
                            }
    
                            //TODO visualizzare il mostro
                            if (!$room->monster->isDie && isset($room->monster)) {
                                print "In questa stanza c'è un mostro: " . $room->monster->name . "\n";
                            } else{
                                print "In questa stanza non ci sono mostri" . "\n";
                            }
                            break;
                        } else {
                            print "Via bloccata uccidi prima il mostro \n";
                        }
                    } else {
                        print "via bloccata \n";
                        print sprintf('Sei ancora nella stanza %s', $room->nRoom);
                    }
                    break;
                case 'move est':
                    $part = 'estPart';

                    $room = Room::checkActualRoom($hero->actualCoor, $rooms);

                    if (Room::checkFreeWay($room->directions, $part)) {

                        if(!isset($room->monster) || $room->monster->isDie){
                        print "via libera \n";
                        $way = $hero->updateCoor('x', 'right');
                        print $way . "\n";

                        $room = Room::checkActualRoom($hero->actualCoor, $rooms);

                        if ($room->nRoom == '9') {
                            $read = new Read('EndWin.txt');
                            print $read->read();
                            exit();
                        } else {
                            $detailsRoom = Room::printDetailsRoom($room);
                            foreach($detailsRoom as $alias => $detail){
                                if (!is_array($detail)) {
                                    print $detail . "\n";
                                } else {
                                    if ($alias == 'freeWays') {
                                        print "Puoi passare in queste vie: \n";
                                        foreach($detail as $way){
                                            print $way . "\n";
                                        }
                                    }
                                }
                            }
                        }

                        //TODO visualizzare l'item nel room
                        if (isset($room->item)) {
                            print "In questa stanza c'è un item: " . $room->item->name . "\n";
                        } else{
                            print "In questa stanza non ci sono item" . "\n";
                        }

                        //TODO visualizzare il mostro
                        if (!$room->monster->isDie && isset($room->monster)) {
                            print "In questa stanza c'è un mostro: " . $room->monster->name . "\n";
                        } else{
                            print "In questa stanza non ci sono mostri" . "\n";
                        }
                        break;
                        } else {
                            print "Via bloccata uccidi prima il mostro \n";
                        }
                    } else {
                        print "via bloccata \n";
                        print sprintf('Sei ancora nella stanza %s', $room->nRoom);
                    }

                    break;
                case 'move west':
                    $part = 'westPart';

                    $room = Room::checkActualRoom($hero->actualCoor, $rooms);

                    if (Room::checkFreeWay($room->directions, $part)) {

                        if(!isset($room->monster) || $room->monster->isDie){
                        print "via libera \n";
                        $way = $hero->updateCoor('x', 'left');
                        print $way . "\n";

                        $room = Room::checkActualRoom($hero->actualCoor, $rooms);

                        if ($room->nRoom == '9') {
                            $read = new Read('EndWin.txt');
                            print $read->read();
                            exit();
                        } else {
                            $detailsRoom = Room::printDetailsRoom($room);
                            foreach($detailsRoom as $alias => $detail){
                                if (!is_array($detail)) {
                                    print $detail . "\n";
                                } else {
                                    if ($alias == 'freeWays') {
                                        print "Puoi passare in queste vie: \n";
                                        foreach($detail as $way){
                                            print $way . "\n";
                                        }
                                    }
                                }
                            }
                        }

                        //TODO visualizzare l'item nel room
                        if (isset($room->item)) {
                            print "In questa stanza c'è un item: " . $room->item->name . "\n";
                        } else{
                            print "In questa stanza non ci sono item" . "\n";
                        }

                        //TODO visualizzare il mostro
                        if (!$room->monster->isDie && isset($room->monster)) {
                            print "In questa stanza c'è un mostro: " . $room->monster->name . "\n";
                        } else{
                            print "In questa stanza non ci sono mostri" . "\n";
                        }
                        } else {
                            print "Via bloccata uccidi prima il mostro \n";
                        }
                    } else {
                        print "via bloccata \n";
                        print sprintf('Sei ancora nella stanza %s', $room->nRoom);
                    }
                    break;
                case 'pick':
                    $room = Room::checkActualRoom($hero->actualCoor, $rooms);

                    if (isset($room->item)) {
                        print "Hai preso l'item" . "\n";
                        $hero->pickItem($room->item);
                        $room->item = null;
                        print "Il tuo zaino contiene: " . "\n";
                        foreach($hero->bag as $item){
                            print $item->name . "\n";
                        }
                    } else{
                        print "Non ci sono item in questa stanza" . "\n";
                    }
                    break;
                case 'drop':
                    $itemDropped = $hero->dropItem();
                    $room = Room::checkActualRoom($hero->actualCoor, $rooms);
                    if (!$hero->bag) {
                        print "Il tuo zaino è vuoto" . "\n";
                    } else {
                        $room->item = $itemDropped;
                        print "Hai lasciato cadere: " . $room->item->name . "\n";
                    }
                    break;
                case 'attack':
                    $room = Room::checkActualRoom($hero->actualCoor, $rooms);
                    
                    if (isset($room->monster) && !$room->monster->isDie) {
                        $res = $hero->attack($room->monster->weakness);
                        if($res){
                            print "Hai ucciso il mostro" . "\n";
                            print "Le vie si sono sbloccate" . "\n";
                            $room->monster->kill();
                            foreach($room->directions as $alias => $dir){
                                if($alias == 'southPart'){
                                    $dir = true;
                                    break;
                                }
                            }
                        } else {
                            print sprintf('Non hai questo item: %s', $room->monster->weakness) . "\n";
                            $read = new Read('EndLose.txt');
                            print $read->read();
                            exit();
                        }
                        break;
                    } else{
                        print "Non ci sono mostri in questa stanza" . "\n";
                        break;
                    }
                    break;
                case 'look':
                    $room = Room::checkActualRoom($hero->actualCoor, $rooms);
                    print sprintf('Sei riuscito a passare nella stanza %s. ', $room->nRoom) . "\n";
                    print $room->description;
                    print "Puoi passare in queste vie: \n";
                    foreach($room->directions as $i => $dir){
                        if (!$dir == false) {
                            print $i . "\n";
                        }
                    }
                    //TODO visualizzare l'item nel room
                    if (isset($room->item)) {
                        print "In questa stanza c'è un item: " . $room->item->name . "\n";
                    } else{
                        print "In questa stanza non ci sono item" . "\n";
                    }

                    //TODO visualizzare il mostro
                    if (isset($room->monster) && !$room->monster->isDie) {
                        print "In questa stanza c'è un mostro: " . $room->monster->name . "\n";
                    } else{
                        print "In questa stanza non ci sono mostri" . "\n";
                    }
                    break;
                case 'exit':
                    break;
                default:
                    print "\n comando non trovato \n";
            }
        } while ($cmd != 'exit');
    }

}

