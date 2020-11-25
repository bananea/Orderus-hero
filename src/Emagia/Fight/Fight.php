<?php

namespace Emagia\Fight;

use Emagia\Hero\Hero as EHero;

class Fight
{
    const MAXIM_ROUNDS = 20;
    const FIRST_ROUND = 1;
    private $oHeroFirst;
    private $oHeroSecond;
    private $iRounds = 1;
    private $sAttackerName;
    private $sDefenderName;
    private $iPlayerAttackThisRound = 1;
    private $hActiveSkillsThisRound = [];

    public function __construct(EHero $oHeroFirst, EHero $oHeroSecond)
    {
        $this->oHeroFirst = $oHeroFirst;
        $this->oHeroSecond = $oHeroSecond;
    }

    public function fightHeroes()
    {
        echo 'Fight starts between ' . $this->oHeroFirst->getSName() . ' health ' . $this->oHeroFirst->getIHealth() . ' strenght '   . $this->oHeroFirst->getIStrength() . ' defence ' .$this->oHeroFirst->getIDefence().
            ' and  ' . $this->oHeroSecond->getSName() .' health ' . $this->oHeroSecond->getIHealth() . ' strenght '   . $this->oHeroSecond->getIStrength() . ' defence ' .$this->oHeroSecond->getIDefence() . PHP_EOL;
        if ($this->iRounds == self::FIRST_ROUND) {
            if ($this->oHeroFirst->getISpeed() < $this->oHeroSecond->getISpeed()) {
                $this->iPlayerAttackThisRound = 2;
            }
        }
        while ($this->oHeroFirst->isAlive() && $this->oHeroSecond->isAlive() && $this->iRounds <= self::MAXIM_ROUNDS) {

            $this->setAttackerAndDefenderNames();
            $this->logRoundStarts();
            $this->fightOneRound();
            $this->switchPlayerAttack();
            $this->hActiveSkillsThisRound = [];
            $this->iRounds++;
        }
    }

    protected function setAttackerAndDefenderNames()
    {
        $this->sAttackerName = $this->oHeroFirst->getSName();
        $this->sDefenderName = $this->oHeroSecond->getSName();
        if ($this->iPlayerAttackThisRound == 2) {
            $this->sAttackerName = $this->oHeroSecond->getSName();
            $this->sDefenderName = $this->oHeroFirst->getSName();
        }
    }

    public function logRoundStarts()
    {
        echo 'Round ' . $this->iRounds . ' starts between Attacker ' . $this->sAttackerName . ' and  Defender ' . $this->sDefenderName . PHP_EOL;
    }

    public function switchPlayerAttack()
    {
        if ($this->iPlayerAttackThisRound == 1) {
            $this->iPlayerAttackThisRound = 2;
            return;
        }
        $this->iPlayerAttackThisRound = 1;
    }

    protected function fightOneRound()
    {

        $this->doRoundDamage();
        echo '------------------------' . PHP_EOL;
    }

    protected function doRoundDamage()
    {
        $iDamage = $this->calculateDamage();
        echo 'Attacker does ' . $iDamage . ' damage ' . PHP_EOL;
        if ($iDamage > 0) {
            $this->substractDamage($iDamage);
        }

    }

    protected function calculateDamage()
    {
        //Damage = Attacker strength – Defender defence
        if ($this->iPlayerAttackThisRound == 1) {
            if (!$this->isSpecialSkillActivatedThisRound()) {
                if ($this->oHeroSecond->isLuckyThisTurn()) {
                    return 0;
                }
                $iDamage = $this->oHeroFirst->getIStrength() - $this->oHeroSecond->getIDefence();
            } else {
                $iDamage = $this->calculateSpecialDamage();
            }

            return $iDamage;
        }
        $iDamage = $this->oHeroSecond->getIStrength() - $this->oHeroFirst->getIDefence();
        return $iDamage;
    }


    protected function substractDamage($iDamage)
    {
        //Damage = Attacker strength – Defender defence
        if ($this->iPlayerAttackThisRound == 1) {
            $iNewHealth = $this->oHeroSecond->getIHealth() - $iDamage;
             $this->oHeroSecond->setIHealth($iNewHealth);
            echo  $this->oHeroSecond->getSName() . ' new health is  ' . $iNewHealth . '  ' . PHP_EOL;
            return;
        }
        $iNewHealth = $this->oHeroFirst->getIHealth() - $iDamage;
        $this->oHeroFirst->setIHealth($iNewHealth);
        echo  $this->oHeroFirst->getSName() . ' new health is  ' . $iNewHealth . '  ' . PHP_EOL;
        return;
    }

    protected function isSpecialSkillActivatedThisRound()
    {
        foreach ($this->oHeroFirst->getHActiveSkills() as $hSkill) {
            if (rand(0, 100) >= $hSkill['how_often_in_100_procent']) {
                array_push($this->hActiveSkillsThisRound, $hSkill['name']);
            }
        }
        return count($this->hActiveSkillsThisRound) > 0;
    }

    protected function calculateSpecialDamage()
    {
        $iDamage = ($this->oHeroSecond->getIStrength() - $this->oHeroFirst->getIDefence());
        if ($this->iPlayerAttackThisRound == 1) {
            foreach ($this->hActiveSkillsThisRound as $sActiveSkillName) {
                if (array_key_exists($sActiveSkillName, $this->oHeroFirst->getHActiveSkills()) && $this->oHeroFirst->getHActiveSkills()[$sActiveSkillName]['active_on'] == 'attack') {
                    echo 'Special attack was is  ' . $sActiveSkillName . '  ' . PHP_EOL;
                    $iDamage *= $this->oHeroFirst->getHActiveSkills()[$sActiveSkillName]['how_much_atacks_more_in_100_procent'] / 100;
                }
            }
        } else {
            foreach ($this->hActiveSkillsThisRound as $sActiveSkillName) {
                if (array_key_exists($sActiveSkillName, $this->oHeroFirst->getHActiveSkills()) && $this->oHeroFirst->getHActiveSkills()[$sActiveSkillName]['active_on'] == 'defense') {
                    echo 'Special defense was is  ' . $sActiveSkillName . '  ' . PHP_EOL;
                    $iDamage *= $this->oHeroFirst->getHActiveSkills()[$sActiveSkillName]['how_much_atacks_more_in_100_procent'] / 100;
                }
            }
        }
        return $iDamage;
    }

}