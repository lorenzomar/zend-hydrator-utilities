<?php

/**
 * This file is part of the ZendHydratorUtilities package.
 *
 * (c) Lorenzo Marzullo <marzullo.lorenzo@gmail.com>
 */

namespace ZendHydratorUtilities\Strategy;

use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\UuidInterface;
use Zend\Hydrator\Strategy\StrategyInterface;

/**
 * Class UuidStrategy.
 *
 * @package ZendHydratorUtilities
 * @package Lorenzo Marzullo <marzullo.lorenzo@gmail.com>
 * @package https://github.com/lorenzomar/zend-hydrator-utilities
 */
class UuidStrategy implements StrategyInterface
{
    public function extract($value)
    {
        if ($value instanceof UuidInterface) {
            return (string) $value;
        }

        return $value;
    }

    public function hydrate($value)
    {
        try {
            return Uuid::fromString($value);
        } catch (\Exception $e) {
            return $value;
        }
    }
}