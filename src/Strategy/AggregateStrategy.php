<?php

/**
 * This file is part of the Coupon package.
 *
 * (c) Lorenzo Marzullo <marzullo.lorenzo@gmail.com>
 */

namespace ZendHydratorUtilities\Strategy;

use Zend\Hydrator\Strategy\StrategyInterface;

/**
 * Class AggregateStrategy
 *
 * @package Coupon
 * @author  Lorenzo Marzullo <marzullo.lorenzo@gmail.com>
 * @link    https://bitbucket.org/coupon/coupon.git
 */
class AggregateStrategy implements StrategyInterface
{
    /**
     * @var StrategyInterface[]
     */
    private $strategies = [];

    public function __construct(array $strategies)
    {
        $this->strategies = $strategies;
    }

    public function extract($value)
    {
        $tmp = is_object($value) ? clone $value : $value;

        foreach ($this->strategies as $strategy) {
            $tmp = $strategy->extract($tmp);
        }

        return $tmp;
    }

    public function hydrate($value)
    {
        foreach (array_reverse($this->strategies) as $strategy) {
            $value = $strategy->hydrate($value);
        }

        return $value;
    }
}