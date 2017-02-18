<?php

/**
 * This file is part of the Coupon package.
 *
 * (c) Lorenzo Marzullo <marzullo.lorenzo@gmail.com>
 */

namespace ZendHydratorUtilities\Strategy;

use Zend\Hydrator\Strategy\StrategyInterface;

/**
 * Class IterativeStrategy
 *
 * @package Coupon
 * @author  Lorenzo Marzullo <marzullo.lorenzo@gmail.com>
 * @link    https://bitbucket.org/coupon/coupon.git
 */
class IterativeStrategy implements StrategyInterface
{
    /**
     * @var StrategyInterface
     */
    private $baseStrategy;

    public function __construct(StrategyInterface $baseStrategy)
    {
        $this->baseStrategy = $baseStrategy;
    }

    public function extract($value)
    {
        if (is_array($value) || $value instanceof \Traversable) {
            $extracted = [];

            foreach ($value as $k => $v) {
                $extracted[$k] = $this->baseStrategy->extract($v);
            }

            return $extracted;
        }

        return $value;
    }

    public function hydrate($value)
    {
        if (is_array($value) || $value instanceof \Traversable) {
            $hydrated = [];

            foreach ($value as $k => $v) {
                try {
                    $hydrated[$k] = $this->baseStrategy->hydrate($v);
                } catch (\Exception $e) {
                    $hydrated[$k] = $v;
                }
            }

            return $hydrated;
        }

        return $value;
    }
}