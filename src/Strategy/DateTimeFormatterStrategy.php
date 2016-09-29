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
     * @var string
     */
    private $format;

    /**
     * @var \DateTimeZone
     */
    private $timezone;

    /**
     * @var BaseDateTimeFormatterStrategy
     */
    private $dateTimeFormatter;

    /**
     * @var bool
     */
    private $useImmutable;

    public function __construct($format = \DateTime::RFC3339, \DateTimeZone $timezone = null, $useImmutable = true)
    {
        $this->dateTimeFormatter = new BaseDateTimeFormatterStrategy($format, $timezone);
        $this->format            = $format;
        $this->timezone          = $timezone;
        $this->useImmutable      = $useImmutable;
    }

    public function extract($value)
    {
        if ($value instanceof \DateTimeImmutable) {
            return $value->format($this->format);
        }

        return $this->dateTimeFormatter->extract($value);
    }

    public function hydrate($value)
    {
        $e = $this->dateTimeFormatter->hydrate($value);

        if ($e instanceof \DateTimeInterface && $this->useImmutable) {
            $e = \DateTimeImmutable::createFromMutable($e);
        }

        return $e;
    }
}
