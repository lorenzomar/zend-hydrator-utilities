<?php

/**
 * This file is part of the ZendHydratorUtilities package.
 *
 * (c) Lorenzo Marzullo <marzullo.lorenzo@gmail.com>
 */

namespace ZendHydratorUtilities\Strategy;

use Money\Currency;
use Zend\Hydrator\Strategy\StrategyInterface;

/**
 * Class MoneyPhpCurrencyStrategy.
 *
 * @package ZendHydratorUtilities
 * @package Lorenzo Marzullo <marzullo.lorenzo@gmail.com>
 * @package https://github.com/lorenzomar/zend-hydrator-utilities
 */
class MoneyPhpCurrencyStrategy implements StrategyInterface
{
    /**
     * @inheritdoc
     *
     * @param mixed|Currency $value
     *
     * @return mixed|string
     */
    public function extract($value)
    {
        return ($value instanceof Currency) ? (string)$value : $value;
    }

    /**
     * @inheritdoc
     *
     * @param mixed|string $value
     *
     * @return mixed|Currency
     */
    public function hydrate($value)
    {
        try {
            return new Currency($value);
        } catch (\Exception $e) {
            //;
        }

        return $value;
    }
}