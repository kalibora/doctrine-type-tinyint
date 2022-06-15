<?php

namespace Kalibora\DoctrineType;

use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\ConversionException;
use PHPUnit\Framework\TestCase;

class TinyintTypeTest extends TestCase
{
    /**
     * @dataProvider providerForConvertToDatabaseValueSuccess
     *
     * @param mixed $value
     * @param mixed $dbValue
     */
    public function testConvertToDatabaseValueSuccess($value, $dbValue) : void
    {
        $type = new TinyintType();

        $this->assertSame(
            $dbValue,
            $type->convertToDatabaseValue(
                $value,
                $this->prophesize(AbstractPlatform::class)->reveal()
            )
        );
    }

    /**
     * @dataProvider providerForConvertToDatabaseValueFailure
     *
     * @param mixed $value
     */
    public function testConvertToDatabaseValueFailure($value, string $message) : void
    {
        $type = new TinyintType();

        $this->expectException(ConversionException::class);
        $this->expectExceptionMessage($message);

        $type->convertToDatabaseValue(
            $value,
            $this->prophesize(AbstractPlatform::class)->reveal()
        );
    }

    public function providerForConvertToDatabaseValueSuccess() : array
    {
        return [
            'null' => [
                'value' => null,
                'dbValue' => null,
            ],
            'string: zero' => [
                'value' => '0',
                'dbValue' => '0',
            ],
            'string: positive number' => [
                'value' => '1',
                'dbValue' => '1',
            ],
            'string: negative number' => [
                'value' => '-100',
                'dbValue' => '-100',
            ],
            'int: zero' => [
                'value' => 0,
                'dbValue' => 0,
            ],
            'int: positive number' => [
                'value' => 1,
                'dbValue' => 1,
            ],
            'int: negative number' => [
                'value' => -100,
                'dbValue' => -100,
            ],
        ];
    }

    public function providerForConvertToDatabaseValueFailure() : array
    {
        return [
            'string: decimal point' => [
                'value' => '1.2',
                'message' => 'Expected integer, got string',
            ],
            'double' => [
                'value' => 1.2,
                'message' => 'Expected integer, got double',
            ],
            'bool' => [
                'value' => true,
                'message' => 'Expected integer, got boolean',
            ],
            'array' => [
                'value' => ['1'],
                'message' => 'Expected integer, got array',
            ],
            'object' => [
                'value' => new \stdClass(),
                'message' => 'Expected integer, got stdClass',
            ],
        ];
    }
}
