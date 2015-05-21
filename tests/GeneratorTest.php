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

    public function testGeneratingTwoPasswordsAreDifferent()
    {
        $this->assertNotEquals($this->g->generate(), $this->g->generate());
    }
}
