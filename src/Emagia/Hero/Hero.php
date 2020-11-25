<?php

namespace Emagia\Hero;
abstract class  Hero
{
    protected $iHealth;
    protected $iStrength;
    protected $iDefence;
    protected $iSpeed;
    protected $iLuck;
    protected $sName;
    protected $hActiveSkills;



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
    public function getHActiveSkills()
    {
        return $this->hActiveSkills;
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

}
