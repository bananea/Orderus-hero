<?php

namespace Emagia\Fight;

use Emagia\Hero\Hero as EHero;
use Emagia\Hero\SpecialSkills as ESpecialSkills;

class Fight
{
    const MAXIM_ROUNDS = 20;
    const FIRST_ROUND = 1;
    const FIRST_HERO_ATTACKS_FIRST = 1;
    const SECOND_HERO_ATTACKS_FIRST = 2;
    private $oHeroFirst;
    private $oHeroSecond;
    private $iRounds = self::FIRST_ROUND;
    private $sAttackerName;
    private $sDefenderName;
    private $iPlayerAttackThisRound = self::FIRST_HERO_ATTACKS_FIRST;

    public function __construct(EHero $oHeroFirst, EHero $oHeroSecond)
    {
        $this->oHeroFirst = $oHeroFirst;
        $this->oHeroSecond = $oHeroSecond;
    }

    public function fightHeroes()
    {
        echo 'Fight starts between :'.PHP_EOL . $this->oHeroFirst->getSName() . ' health ' . $this->oHeroFirst->getIHealth() . ' strenght '
            . $this->oHeroFirst->getIStrength() . ' defence ' . $this->oHeroFirst->getIDefence() . ' speed '. $this->oHeroFirst->getISpeed() .
            ' and  '. PHP_EOL . $this->oHeroSecond->getSName() . ' health ' . $this->oHeroSecond->getIHealth() . ' strenght ' . $this->oHeroSecond->getIStrength() .
            ' defence ' . $this->oHeroSecond->getIDefence() . ' speed '. $this->oHeroSecond->getISpeed()  . PHP_EOL;
        if ($this->iRounds == self::FIRST_ROUND) {
            if ($this->oHeroFirst->getISpeed() < $this->oHeroSecond->getISpeed()) {
                $this->iPlayerAttackThisRound = self::SECOND_HERO_ATTACKS_FIRST;
            }
        }
        while ($this->oHeroFirst->isAlive() && $this->oHeroSecond->isAlive() && $this->iRounds <= self::MAXIM_ROUNDS) {
            $this->setAttackerAndDefenderNames();
            $this->logRoundStarts();

            if ($this->iPlayerAttackThisRound == self::FIRST_HERO_ATTACKS_FIRST) {
                $this->oHeroFirst->initHeroSpecialSkillsByType('attack');
                $this->oHeroSecond->initHeroSpecialSkillsByType('defence');
                $this->fightOneRound($this->oHeroFirst, $this->oHeroSecond);
            } else {
                $this->oHeroSecond->initHeroSpecialSkillsByType('attack');
                $this->oHeroFirst->initHeroSpecialSkillsByType('defence');
                $this->fightOneRound($this->oHeroSecond, $this->oHeroFirst);
            }
            $this->oHeroFirst->resetHSpecialSkills();
            $this->oHeroSecond->resetHSpecialSkills();
            $this->switchPlayerAttack();
            $this->iRounds++;
        }
        if ($this->iRounds <= self::MAXIM_ROUNDS) {
            if ($this->oHeroFirst->isAlive() ) {
                echo 'Winner is :'. $this->oHeroFirst->getSName() .PHP_EOL;
            } else {
                echo 'Winner is :'. $this->oHeroSecond->getSName() .PHP_EOL;
            }
        }
    }



    protected function setAttackerAndDefenderNames()
    {
        $this->sAttackerName = $this->oHeroFirst->getSName();
        $this->sDefenderName = $this->oHeroSecond->getSName();
        if ($this->iPlayerAttackThisRound == self::SECOND_HERO_ATTACKS_FIRST) {
            $this->sAttackerName = $this->oHeroSecond->getSName();
            $this->sDefenderName = $this->oHeroFirst->getSName();
        }
    }

    public function logRoundStarts()
    {
        echo '--Round ' . $this->iRounds . ' starts between Attacker ' . $this->sAttackerName . ' and  Defender ' . $this->sDefenderName . PHP_EOL;
    }

    public function switchPlayerAttack()
    {
        if ($this->iPlayerAttackThisRound == self::FIRST_HERO_ATTACKS_FIRST) {
            $this->iPlayerAttackThisRound = self::SECOND_HERO_ATTACKS_FIRST;
            return;
        }
        $this->iPlayerAttackThisRound = self::FIRST_HERO_ATTACKS_FIRST;
    }

    public function fightOneRound(EHero $oAttacker, EHero $oDefender)
    {
        $iDamage = $this->calculateDamage($oAttacker, $oDefender);
        echo 'Attacker does ' . $iDamage . ' damage ' . PHP_EOL;
        if ($iDamage > 0) {
            $this->substractDamage($oAttacker, $oDefender,$iDamage);
        }

    }

    protected function calculateDamage(EHero $oAttacker, EHero $oDefender)
    {
        //Damage = Attacker strength – Defender defence
        if (!$this->isSpecialSkillActivatedThisRound($oAttacker) && !$this->isSpecialSkillActivatedThisRound($oDefender)) {
            if ($oDefender->isLuckyThisTurn()) {
                echo 'Defender gets lucky this turn!' . PHP_EOL;
                return 0;
            }
            $iDamage = $oAttacker->getIStrength() - $oDefender->getIDefence();
        } else {
            $iDamage = $this->calculateSpecialDamage($oAttacker, $oDefender);
        }

        return $iDamage;
    }


    protected function substractDamage(EHero $oAttacker, EHero $oDefender,$iDamage)
    {
        //Damage = Attacker strength – Defender defence
            $iNewHealth = $oDefender->getIHealth() - $iDamage;
            $oDefender->setIHealth($iNewHealth);
            echo $oDefender->getSName() . ' new health is  ' . $iNewHealth . '  ' . PHP_EOL;
            return;

    }

    protected function isSpecialSkillActivatedThisRound(EHero $oHero)
    {
        return count($oHero->getHActiveSpecialSkills()) > 0;
    }

    protected function calculateSpecialDamage(EHero $oAttacker, EHero $oDefender)
    {
        $iDamage = $oAttacker->getIStrength() - $oDefender->getIDefence();
        foreach ($oAttacker->getHActiveSpecialSkills() as $sActiveSkillName) {
            $oSpecialSkills = new  ESpecialSkills();
            $hSpecialSkills = $oSpecialSkills->getSkillByName($sActiveSkillName);
            echo 'Special Skill ocurred: '. $sActiveSkillName. PHP_EOL;
            $iDamage *=$hSpecialSkills['how_much_multiplies_damage'];
        }
        foreach ($oDefender->getHActiveSpecialSkills() as $sActiveSkillName) {
            $oSpecialSkills = new  ESpecialSkills();
            $hSpecialSkills = $oSpecialSkills->getSkillByName($sActiveSkillName);
            echo 'Special Skill ocurred: '. $sActiveSkillName. PHP_EOL;
            $iDamage *=$hSpecialSkills['how_much_multiplies_damage'];
        }
        return $iDamage;
    }

}