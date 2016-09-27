<?php

/**
 * This file is part of the ZendHydratorUtilities package.
 *
 * (c) Lorenzo Marzullo <marzullo.lorenzo@gmail.com>
 */

namespace ZendHydratorUtilities\Strategy;

use Zend\Hydrator\Strategy\StrategyInterface;

/**
 * Class JsonSerializerStrategy.
 *
 * @package ZendHydratorUtilities
 * @package Lorenzo Marzullo <marzullo.lorenzo@gmail.com>
 * @package https://github.com/lorenzomar/zend-hydrator-utilities
 */
class JsonSerializerStrategy implements StrategyInterface
{
    /**
     * @var bool
     */
    private $decodeAsAssoc;

    public function __construct($decodeAsAssoc = true)
    {
        $this->decodeAsAssoc = (bool) $decodeAsAssoc;
    }

    public function extract($value)
    {
        if (is_null($value)) {
            return null;
        }

        return json_encode($value);
    }

    public function hydrate($value)
    {
        if (is_null($value)) {
            return null;
        }

        json_decode($value, $this->decodeAsAssoc);
    }
}