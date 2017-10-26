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
    private $symbols = ['!', '@', '$', '%', '^', '&', '*', ':', ';', '?', ',', '.'];

    /**
     * Serial format of the generated password
     *
     * @var array
     */
    private $format = ['word', 'num', 'symbol', 'word', 'symbol'];

    /**
     * Constructor
     *
     * @param string $locale The locale to be used by faker
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
     * @param int $num The number of passwords to generate
     *
     * @return string
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
            $password = "";
            foreach ($this->format as $element) {
                switch ($element) {
                    case "word":
                        $password .= preg_replace('/(?<=\w) .*/', "", $this->faker->streetName);
                        break;
                    case "num":
                        $password .= $this->faker->randomNumber(3);
                        break;
                    case "symbol":
                        $password .= $this->getSymbol();
                        break;
                }
            }
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
            throw new \InvalidArgumentException(
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
     *
     * @throws InvalidArgumentException if the provided argument is not of type
     *     'string'.
     *
     * @return void
     */
    public function removeSymbol($char)
    {
        if (($key = array_search($char, $this->symbols)) !== false) {
            unset($this->symbols[$key]);
        }
    }

    /**
     * Public facing method to set the list of allowed symbols manually.
     * Only adds strings of length 1, discards anything else passed to it.
     *
     * @param array $chars The array of characters to set
     *
     * @throws InvalidArgumentException if the provided array is empty
     *
     * @return void
     */
    public function setSymbols(array $chars)
    {
        if (count($chars) === 0) {
            throw new \InvalidArgumentException(
                'setSymbols expects a non-empty array!'
            );
        }

        $this->symbols = [];
        foreach ($chars as $char) {
            $this->addSymbol($char);
        }
    }

    /**
     * Get a random symbol from the list of allowed symbols
     *
     * @return string
     */
    private function getSymbol()
    {
        return $this->faker->randomElement($this->symbols);
    }

    /**
     * Public facing method to set the order in which password elements are
     * generated. Ignores non-valid format values.
     *
     * @param array $seed The order you wish the password elements to display
     *
     * @return void
     */
    public function setFormat(array $format)
    {
        if (count($format) === 0) {
            throw new \InvalidArgumentException(
                'setFormat expects a non-empty array!'
            );
        }

        $allowed = ['word', 'num', 'symbol'];

        $this->format = [];

        foreach ($format as $item) {
            if (in_array($item, $allowed)) {
                $this->format[] = $item;
            }
        }
    }
}
