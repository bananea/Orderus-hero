<?php


namespace Emagia\Hero;


class SpecialSkills
{
    protected $hSpecialSkills = [
       [
            'name' => 'RapidStrike',
            'active_on' => 'attack',
            'how_often_in_100_procent' => 20,
            'how_much_multiplies_damage' => 2
        ],
        [
            'name' => 'MagicShield',
            'active_on' => 'defense',
            'how_often_in_100_procent' => 20,
            'how_much_multiplies_damage' => 0.5
        ]
    ];

    public function getSkillByName ($sName) {
        foreach ($this->hSpecialSkills as $hSpecialSkill) {
            if ($hSpecialSkill['name'] == $sName ) {
                return $hSpecialSkill;
            }
        }
    }

    public function getSkillByNameAndType ($sName, $sType) {
        foreach ($this->hSpecialSkills as $hSpecialSkill) {
            if ($hSpecialSkill['name'] == $sName && $hSpecialSkill['active_on'] == $sType) {
                return $hSpecialSkill;
            }
        }
    }

}