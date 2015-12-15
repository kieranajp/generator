<?php

namespace Kieranajp\Generator;

use Faker\Factory as Faker;

class Generator
{
    /**
     * Holds an instance of \Faker\Factory
     *
     * @var \Faker\Factory
     */
    private $faker;

    /**
     * List of allowed symbols to include in password
     *
     * @var array
     */
    private $symbols = [ '!', '@', '$', '%', '^', '&', '*', ':', ';', '?', ',', '.' ];

    /**
     * Constructor
     *
     * @return void
     */
    public function __construct($locale = "en_US")
    {
        $this->faker = Faker::create($locale);
    }

    /**
     * Public facing method to generate password(s)
     *
     * @return string password
     */
    public function generate($num = 1)
    {
        if (!is_int($num)) {
            throw new InvalidArgumentException(
                sprintf(
                    'generate expects parameter 1 of type int. %s given.',
                    gettype($num)
                )
            );
        }

        $passwords = [];
        while (count($passwords) < $num) {
            $password    = $this->faker->streetName;
            $password    = preg_replace('/\W/', $this->getSymbol(), $password);
            $password   .= $this->faker->randomNumber(3) . $this->getSymbol();
            $passwords[] = $password;
        }

        return count($passwords) > 1 ? $passwords : $passwords[0];
    }

    /**
     * Public facing method to add a char to the list of allowed symbols
     *
     * @param string $char The symbol to add
     * @return void
     */
    public function addSymbol($char)
    {
        if (!is_string($char) || strlen($char) > 1) {
            throw new InvalidArgumentException(
                sprintf(
                    'addSymbol expects parameter 1 of type string, length 1. "%s" (%s) given.',
                    $char,
                    gettype($char)
                )
            );
        }

        $this->symbols[] = $char;
    }

    /**
     * Public facing method to remove a char from the list of allowed symbols
     *
     * @param string $char The symbol to remove
     * @return void
     */
    public function removeSymbol($char)
    {
        if (!is_string($char) || strlen($char) > 1) {
            throw new InvalidArgumentException(
                sprintf(
                    'removeSymbol expects parameter 1 of type string, length 1. "%s" (%s) given.',
                    $char,
                    gettype($char)
                )
            );
        }

        if (($key = array_search($char, $this->symbols)) !== false) {
            unset($this->symbols[$key]);
        }
    }

    /**
     * Public facing method to set the list of allowed symbols manually.
     * Only adds strings of length 1, discards anything else passed to it.
     *
     * @param array $chars The array of characters to set
     * @return void
     */
    public function setSymbols(array $chars)
    {
        $this->symbols = array_filter($chars, function ($char) {
            return (is_string($char) && strlen($char) === 1);
        });
    }

    /**
     * Get a random symbol from the list of allowed symbols
     *
     * @return string symbol
     */
    private function getSymbol()
    {
        return $this->faker->randomElement($this->symbols);
    }
}
