<?php

use Kieranajp\Generator\Generator;

class GeneratorTest extends PHPUnit_Framework_TestCase
{
    protected $g;

    private function publicify($parameter)
    {
        $publicify = function (Generator $g) use ($parameter) {
            return $g->{$parameter};
        };
        return Closure::bind($publicify, null, $this->g);
    }

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
        $this->assertInternalType('string', $this->g->generate()[0]);
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
        $publicify = $this->publicify('symbols');

        $this->g->addSymbol('>');

        $this->assertContains('>', $publicify($this->g));
    }

    /**
     * @expectedException \InvalidArgumentException
     */
    public function testAddingATooLongSymbol()
    {
        $this->g->addSymbol('herp');
    }

    public function testRemovingASymbol()
    {
        $publicify = $this->publicify('symbols');

        $this->g->removeSymbol('&');

        $this->assertFalse(in_array('&', $publicify($this->g)));
    }

    public function testSettingAllSymbols()
    {
        $publicify = $this->publicify('symbols');

        $this->g->setSymbols(['&']);

        $this->assertEquals(['&'], $publicify($this->g));
    }

    /**
     * @expectedException \InvalidArgumentException
     */
    public function testSettingAllSymbolsWithEmptyArray()
    {
        $this->g->setSymbols([]);
    }

    public function testSettingFormat()
    {
        $publicify = $this->publicify('format');

        $this->g->setFormat(['word', 'symbol', 'word']);

        $this->assertEquals(['word', 'symbol', 'word'], $publicify($this->g));
    }

    public function testSettingInvalidFormatIsIgnored()
    {
        $publicify = $this->publicify('format');

        $this->g->setFormat(['word', 'banana', 'word']);

        $this->assertEquals(['word', 'word'], $publicify($this->g));
    }

    /**
     * @expectedException \InvalidArgumentException
     */
    public function testSettingEmptyFormat()
    {
        $this->g->setFormat([]);
    }
}
