<?php

namespace Kalibora\DoctrineType;

use Doctrine\DBAL\ParameterType;
use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Platforms\MySQLPlatform;
use Doctrine\DBAL\Types\ConversionException;
use Doctrine\DBAL\Types\Type;

class TinyintType extends Type
{
    public const TINYINT = 'tinyint';

    public function getName()
    {
        return self::TINYINT;
    }

    public function getSQLDeclaration(array $fieldDeclaration, AbstractPlatform $platform)
    {
        if (!$platform instanceof MySQLPlatform) {
            throw new \LogicException('This type only support mysql');
        }

        $unsigned = $fieldDeclaration['unsigned'] ? ' UNSIGNED' : '';

        if ($fieldDeclaration['length'] && is_numeric($fieldDeclaration['length'])) {
            $sql = sprintf('TINYINT(%d)', $fieldDeclaration['length']);
        } else {
            $sql = 'TINYINT';
        }

        return $sql . $unsigned;
    }

    public function convertToDatabaseValue($value, AbstractPlatform $platform)
    {
        if (null === $value) {
            return null;
        }

        if (is_int($value)) {
            return $value;
        }

        if (is_string($value) && preg_match('/^-?\d+$/', $value)) {
            return $value;
        }

        throw new ConversionException(sprintf('Expected integer, got %s', is_object($value) ? get_class($value) : gettype($value)));
    }

    public function convertToPHPValue($value, AbstractPlatform $platform)
    {
        /* @phpstan-ignore-next-line It is guaranteed by the database to be null or a string-represented integer. */
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
