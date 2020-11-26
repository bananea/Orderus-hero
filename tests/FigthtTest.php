<?php
use PHPUnit\Framework\TestCase;
use Emagia\Hero\Hero as EHero;
use Emagia\Hero\Orderus as EOrderus;
use Emagia\Hero\WildBeast as EWildBeast;
use Emagia\Fight\Fight as EFight;

final class FightTest extends TestCase
{
    private $oHero1;
    private $oHero2;

    protected function setUp() {
       // $this->oHero1 = new EOrderus();
        $this->oHero1 = $this->getMockBuilder(EOrderus::class)
            ->disableOriginalConstructor()
            ->setMethods(['isLuckyThisTurn'])
            ->getMock();
       // $this->oHero2 = new EWildBeast();
        $this->oHero2 = $this->getMockBuilder(EWildBeast::class)
            ->disableOriginalConstructor()
            ->setMethods(['isLuckyThisTurn'])
            ->getMock();
        $this->initHeroesWithValues();
    }

    protected function initHeroesWithValues () {
        $this->oHero1->setIHealth(75);
        $this->oHero1->setIStrength(73);
        $this->oHero1->setIDefence(52);
        $this->oHero1->setISpeed(41);
        $this->oHero1->setILuck(10);

        $this->oHero2->setIHealth(74);
        $this->oHero2->setIStrength(70);
        $this->oHero2->setIDefence(49);
        $this->oHero2->setISpeed(43);
        $this->oHero2->setILuck(30);
    }

    public function testFightNormalOneRound(): void
    {
        $mockFight = $this->getMockBuilder(EFight::class)
            ->disableOriginalConstructor()
            ->setMethods(['isSpecialSkillActivatedThisRound'])
            ->getMock();

        $mockFight->expects($this->any())
            ->method('isSpecialSkillActivatedThisRound')
            ->will($this->returnValue(false));

        $this->oHero2->expects($this->any())
            ->method('isLuckyThisTurn')
            ->will($this->returnValue(false));

        $mockFight->fightOneRound($this->oHero1, $this->oHero2);
        $this->assertEquals(50, $this->oHero2->getIHealth());
    }

    public function testFightNormalOneRoundWithGettinLucky(): void
    {
        $mockFight = $this->getMockBuilder(EFight::class)
            ->disableOriginalConstructor()
            ->setMethods(['isSpecialSkillActivatedThisRound'])
            ->getMock();

        $mockFight->expects($this->any())
            ->method('isSpecialSkillActivatedThisRound')
            ->will($this->returnValue(false));

        $this->oHero2->expects($this->any())
            ->method('isLuckyThisTurn')
            ->will($this->returnValue(true));

        $mockFight->fightOneRound($this->oHero1, $this->oHero2);
        $this->assertEquals(74, $this->oHero2->getIHealth());
    }

}