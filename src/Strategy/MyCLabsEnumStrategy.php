<?php

/**
 * This file is part of the ZendHydratorUtilities package.
 *
 * (c) Lorenzo Marzullo <marzullo.lorenzo@gmail.com>
 */

namespace ZendHydratorUtilities\Strategy;

use MyCLabs\Enum\Enum;
use Zend\Hydrator\Strategy\StrategyInterface;

/**
 * Class MyCLabsEnumStrategy.
 *
 * @package ZendHydratorUtilities
 * @package Lorenzo Marzullo <marzullo.lorenzo@gmail.com>
 * @package https://github.com/lorenzomar/zend-hydrator-utilities
 */
class MyCLabsEnumStrategy implements StrategyInterface
{
    /**
     * @var string
     */
    private $enumFqn;

    public function __construct($enumFqn)
    {
        $this->enumFqn = $enumFqn;
    }

    /**
     * {@inheritDoc}
     *
     * @param mixed|Enum $value
     *
     * @return mixed|string
     */
    public function extract($value)
    {
        if ($value instanceof Enum && get_class($value) === $this->enumFqn) {
            return (string)$value;
        }

        return $value;
    }

    /**
     * {@inheritDoc}
     *
     * @param mixed|string $value
     *
     * @return mixed|Enum
     */
    public function hydrate($value)
    {
        try {
            return new $this->enumFqn($value);
        } catch (\Exception $e) {
            //
        }

        return $value;
    }
}