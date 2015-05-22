<?php

use Kieranajp\Generator\Generator;

class GeneratorTest extends PHPUnit_Framework_TestCase
{
    protected $g;

    public function setUp()
    {
        $this->g = new Generator();
    }

    public function testInstantiation()
    {
        $g = new Generator();
        $this->assertInstanceOf('Kieranajp\Generator\Generator', $g);
    }

    public function testGeneratingAPassword()
    {
        $this->assertInternalType('string', $this->g->generate());
    }

    public function testGeneratingMultiplePasswords()
    {
        $pws = $this->g->generate(2);

        $this->assertEquals(count($pws), 2);
        $this->assertInternalType('string', $pws[0]);
        $this->assertNotEquals($pws[0], $pws[1]);
    }

    public function testGeneratingTwoPasswordsAreDifferent()
    {
        $this->assertNotEquals($this->g->generate(), $this->g->generate());
    }

    public function testAddingASymbol()
    {
        $thief = function (Generator $g) {
            return $g->symbols;
        };
        $thief = Closure::bind($thief, null, $this->g);

        $this->g->addSymbol('>');

        $this->assertContains('>', $thief($this->g));
    }
}
