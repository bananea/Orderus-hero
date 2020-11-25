<?php
require_once 'vendor/autoload.php';
use Emagia\Hero\Hero as EHero;
use Emagia\Hero\Orderus as EOrderus;
use Emagia\Hero\WildBeast as EWildBeast;
use Emagia\Fight\Fight as EFight;


$heroGame = new EOrderus();
$heroGame2 = new EWildBeast();


$fight = new EFight($heroGame, $heroGame2);
$fight->fightHeroes();