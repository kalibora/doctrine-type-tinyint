<?php

namespace Kalibora\DoctrineType;

use Doctrine\DBAL\ParameterType;
use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Platforms\MySqlPlatform;
use Doctrine\DBAL\Types\Type;

class TinyintType extends Type
{
    const TINYINT = 'tinyint';

    public function getName()
    {
        return self::TINYINT;
    }

    public function getSQLDeclaration(array $fieldDeclaration, AbstractPlatform $platform)
    {
        if (!$platform instanceof MySqlPlatform) {
            throw new \Exception('This type only support mysql');
        }

        $unsigned = (bool) $fieldDeclaration['unsigned'] ? ' UNSIGNED' : '';

        if ((bool) $fieldDeclaration['length']) {
            $sql = sprintf('TINYINT(%d)', $fieldDeclaration['length']);
        } else {
            $sql = 'TINYINT';
        }

        return $sql . $unsigned;
    }

    public function convertToPHPValue($value, AbstractPlatform $platform)
    {
        return null === $value ? null : (int) $value;
    }

    public function getBindingType()
    {
        return ParameterType::INTEGER;
    }

    public function requiresSQLCommentHint(AbstractPlatform $platform)
    {
        return true;
    }
}
