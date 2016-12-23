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
     * @var \DateTimeZone|null
     */
    private $timezone;

    /**
     * @var bool
     */
    private $useImmutable;

    public function __construct($format = \DateTime::RFC3339, \DateTimeZone $timezone = null, $useImmutable = true)
    {
        $this->format       = (string)$format;
        $this->timezone     = $timezone;
        $this->useImmutable = $useImmutable;
    }

    /**
     * {@inheritDoc}
     *
     * Converts to date time string
     *
     * @param mixed|\DateTimeInterface $value
     *
     * @return mixed|string
     */
    public function extract($value)
    {
        if ($value instanceof \DateTimeInterface) {
            return $value->format($this->format);
        }

        return $value;
    }

    /**
     * Converts date time string to DateTime instance for injecting to object
     *
     * {@inheritDoc}
     *
     * @param mixed|string $value
     *
     * @return mixed|\DateTimeInterface
     */
    public function hydrate($value)
    {
        if ($value === '' || $value === null) {
            return;
        }

        if ($this->timezone) {
            $hydrated = $this->useImmutable ?
                \DateTimeImmutable::createFromFormat($this->format, $value, $this->timezone) :
                \DateTime::createFromFormat($this->format, $value, $this->timezone);
        } else {
            $hydrated = $this->useImmutable ?
                \DateTimeImmutable::createFromFormat($this->format, $value) :
                \DateTime::createFromFormat($this->format, $value);
        }

        return $hydrated ?: $value;
    }
}
