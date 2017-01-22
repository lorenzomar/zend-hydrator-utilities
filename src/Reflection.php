<?php

/**
 * This file is part of the ZendHydratorUtilities package.
 *
 * (c) Lorenzo Marzullo <marzullo.lorenzo@gmail.com>
 */

namespace ZendHydratorUtilities;

use Zend\Hydrator\NamingStrategy\NamingStrategyInterface;
use Zend\Hydrator\Reflection as BaseReflection;
use Zend\Hydrator\Strategy\StrategyInterface;

/**
 * Class Reflection.
 *
 * @package ZendHydratorUtilities
 * @package Lorenzo Marzullo <marzullo.lorenzo@gmail.com>
 * @package https://github.com/lorenzomar/zend-hydrator-utilities
 */
class Reflection extends BaseReflection
{
    public function __construct(NamingStrategyInterface $namingStrategy = null, array $strategies = [])
    {
        parent::__construct();

        if ($namingStrategy !== null) {
            $this->setNamingStrategy($namingStrategy);
        }

        foreach ($strategies as $name => $strategy) {
            if ($strategy instanceof StrategyInterface) {
                $this->addStrategy($name, $strategy);
            }
        }
    }

    /**
     * @inheritdoc
     *
     * @return object
     */
    public function hydrate(array $data, $classNameOrObject)
    {
        $object = $this->buildObject($classNameOrObject);

        return parent::hydrate($data, $object);
    }

    protected function buildObject($classNameOrObject)
    {
        return is_object($classNameOrObject) ?
            $classNameOrObject :
            unserialize(sprintf('O:%d:"%s":0:{}', strlen($classNameOrObject), $classNameOrObject));
    }
}