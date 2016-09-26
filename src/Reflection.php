<?php

/**
 * This file is part of the ZendHydratorUtilities package.
 *
 * (c) Lorenzo Marzullo <marzullo.lorenzo@gmail.com>
 */

namespace ZendHydratorUtilities;

use Zend\Hydrator\Reflection as BaseReflection;

/**
 * Class Reflection.
 *
 * @package ZendHydratorUtilities
 * @package Lorenzo Marzullo <marzullo.lorenzo@gmail.com>
 * @package https://github.com/lorenzomar/zend-hydrator-utilities
 */
class Reflection extends BaseReflection
{
    /**
     * @inheritdoc
     *
     * @return object
     */
    public function hydrate(array $data, $className)
    {
        $object = $this->buildObject($className);

        return parent::hydrate($data, $object);
    }

    protected function buildObject($className)
    {
        return unserialize(sprintf('O:%d:"%s":0:{}', strlen($className), $className));
    }
}