<?php

/**
 * This file is part of the ZendHydratorUtilities package.
 *
 * (c) Lorenzo Marzullo <marzullo.lorenzo@gmail.com>
 */

namespace ZendHydratorUtilities\Strategy;

use Zend\Hydrator\Strategy\DateTimeFormatterStrategy as BaseDateTimeFormatterStrategy;
use Zend\Hydrator\Strategy\StrategyInterface;

/**
 * Class DateTimeFormatterStrategy.
 *
 * @package ZendHydratorUtilities
 * @package Lorenzo Marzullo <marzullo.lorenzo@gmail.com>
 * @package https://github.com/lorenzomar/zend-hydrator-utilities
 */
class DateTimeFormatterStrategy implements StrategyInterface
{
    /**
     * @var BaseDateTimeFormatterStrategy
     */
    private $dateTimeFormatter;

    /**
     * @var bool
     */
    private $useImmutable;

    public function __construct($useImmutable = true, $format = \DateTime::RFC3339, \DateTimeZone $timezone = null)
    {
        $this->dateTimeFormatter = new BaseDateTimeFormatterStrategy($format, $timezone);
        $this->useImmutable      = true;
    }

    public function extract($value)
    {
        return $this->dateTimeFormatter->extract($value);
    }

    public function hydrate($value)
    {
        $e = $this->dateTimeFormatter->extract($value);

        if ($e instanceof \DateTimeInterface && $this->useImmutable) {
            $e = \DateTimeImmutable::createFromMutable($e);
        }

        return $e;
    }
}