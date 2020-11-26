<?php

namespace Emagia\Hero;

use Emagia\Hero\SpecialSkills as ESpecialSkills;
abstract class  Hero
{
    const ACTIVE_SKILL_THIS_ROUND = 1;
    const NOT_ACTIVE_SKILL_THIS_ROUND = 0;
    protected $iHealth;
    protected $iStrength;
    protected $iDefence;
    protected $iSpeed;
    protected $iLuck;
    protected $sName;
    protected $hSpecialSkills = [];

    protected $hActiveSpecialSkills = [];




    /**
     * @return mixed
     */
    public function getIHealth()
    {
        return $this->iHealth;
    }

    /**
     * @return mixed
     */
    public function getSName()
    {
        return $this->sName;
    }

    /**
     * @return mixed
     */
    public function getIDefence()
    {
        return $this->iDefence;
    }

    /**
     * @return mixed
     */
    public function getILuck()
    {
        return $this->iLuck;
    }

    /**
     * @return mixed
     */
    public function getISpeed()
    {
        return $this->iSpeed;
    }

    /**
     * @return mixed
     */
    public function getIStrength()
    {
        return $this->iStrength;
    }

    /**
     * @return mixed
     */
    public function getHSpecialSkills()
    {
        return $this->hSpecialSkills;
    }

    /**
     * @return mixed
     */
    public function getHActiveSpecialSkills()
    {
        return $this->hActiveSpecialSkills;
    }

    /**
     * @return mixed
     */
    public function activateHSpecialSkills($sSkill)
    {
        if (in_array($sSkill, $this->hSpecialSkills)) {
            array_push($this->hActiveSpecialSkills, $sSkill);
        }
    }

    /**
     * @return mixed
     */
    public function resetHSpecialSkills()
    {
        $this->hActiveSpecialSkills = [];
    }

    /**
     * @param mixed $iDefence
     */
    public function setIDefence($iDefence)
    {
        $this->iDefence = $iDefence;
    }

    /**
     * @param mixed $iHealth
     */
    public function setIHealth($iHealth)
    {
        $this->iHealth = $iHealth;
    }

    /**
     * @param mixed $iLuck
     */
    public function setILuck($iLuck)
    {
        $this->iLuck = $iLuck;
    }

    /**
     * @param mixed $iSpeed
     */
    public function setISpeed($iSpeed)
    {
        $this->iSpeed = $iSpeed;
    }

    /**
     * @param mixed $iStrength
     */
    public function setIStrength($iStrength)
    {
        $this->iStrength = $iStrength;
    }

    public function isAlive()
    {
        return ($this->iHealth > 0);
    }

    public function isLuckyThisTurn () {
        $iRandomLucky = rand(0,100);
        if ($this->getILuck() > $iRandomLucky) {
            return true;
        }
        return false;
    }

    public function initHeroSpecialSkillsByType($sType) {
        foreach ($this->getHSpecialSkills() as $sSkill) {
            $iLuckProcent = rand(0, 100);
            $oSpecialSkills = new  ESpecialSkills();
            $hSpecialSkills = $oSpecialSkills->getSkillByNameAndType($sSkill,$sType);
            if (!empty($hSpecialSkills) && $iLuckProcent >= $hSpecialSkills['how_often_in_100_procent']) {
                array_push($this->hActiveSpecialSkills,$sSkill);
            }
        }
    }

}
