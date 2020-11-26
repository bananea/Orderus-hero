<?php

namespace Emagia\Hero;

class Orderus extends Hero
{
    private $hOrderusPropeties = [
        'MIN_HEALTH' => 70,
        'MAX_HEALTH' => 100,
        'MIN_STRENGTH' => 70,
        'MAX_STRENGTH' => 80,
        'MIN_DEFENCE' => 45,
        'MAX_DEFENCE' => 55,
        'MIN_SPEED' => 40,
        'MAX_SPEED' => 50,
        'MIN_LUCK' => 10,
        'MAX_LUCK' => 30,
    ];
    protected $hSpecialSkills = [
        'RapidStrike' ,'MagicShield'
    ];

    public function __construct()
    {
        $this->sName = 'Orderus';
        $this->setRandomProperties();
    }

    protected function setRandomProperties()
    {
        //TO DO make a array of Hero Prop and set up in a foreach
        $this->iHealth = rand($this->hOrderusPropeties['MIN_HEALTH'], $this->hOrderusPropeties['MAX_HEALTH']);
        $this->iStrength = rand($this->hOrderusPropeties['MIN_STRENGTH'], $this->hOrderusPropeties['MAX_STRENGTH']);
        $this->iDefence = rand($this->hOrderusPropeties['MIN_DEFENCE'], $this->hOrderusPropeties['MAX_DEFENCE']);
        $this->iSpeed = rand($this->hOrderusPropeties['MIN_SPEED'], $this->hOrderusPropeties['MAX_SPEED']);
        $this->iLuck = rand($this->hOrderusPropeties['MIN_LUCK'], $this->hOrderusPropeties['MAX_LUCK']);

    }

}