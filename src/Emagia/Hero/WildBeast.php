<?php


namespace Emagia\Hero;


class WildBeast extends Hero
{
    private $hWildBeastPropeties = [
        'MIN_HEALTH' => 70,
        'MAX_HEALTH' => 100,
        'MIN_STRENGTH' => 70,
        'MAX_STRENGTH' => 80,
        'MIN_DEFENCE' => 45,
        'MAX_DEFENCE' => 55,
        'MIN_SPEED' => 40,
        'MAX_SPEED' => 50,
        'MIN_LUCK' => 25,
        'MAX_LUCK' => 40,
    ];
    public function __construct()
    {
        $this->sName = 'WildBeast';
        $this->setRandomProperties();
    }

    protected function setRandomProperties() {
        //TO DO make a array of Hero Prop and set up in a foreach
        $this->iHealth = rand($this->hWildBeastPropeties['MIN_HEALTH'], $this->hWildBeastPropeties['MAX_HEALTH']);
        $this->iStrength = rand($this->hWildBeastPropeties['MIN_STRENGTH'], $this->hWildBeastPropeties['MAX_STRENGTH']);
        $this->iDefence = rand($this->hWildBeastPropeties['MIN_DEFENCE'], $this->hWildBeastPropeties['MAX_DEFENCE']);
        $this->iSpeed = rand($this->hWildBeastPropeties['MIN_SPEED'], $this->hWildBeastPropeties['MAX_SPEED']);
        $this->iLuck = rand($this->hWildBeastPropeties['MIN_LUCK'], $this->hWildBeastPropeties['MAX_LUCK']);
    }
}