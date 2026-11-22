<?php

namespace App\Tests\Entity;

use App\Entity\Measurement;
use PHPUnit\Framework\TestCase;
use PHPUnit\Framework\Attributes\DataProvider;

class MeasurementTest extends TestCase
{

    public static function dataGetFahrenheit(): array
    {
        return [
            ['0', '32'],
            ['-100', '-148'],
            ['100', '212'],
            ['0.5', '32.9'],
            ['10', '50'],
            ['15', '59'],
            ['35', '95'],
            ['-40', '-40'],
            ['-85', '-121'],
            ['120', '248'],
        ];
    }

    #[DataProvider('dataGetFahrenheit')]
    public function testGetFahrenheit(string $celsius, string $expectedFahrenheit): void
    {
        $measurmentEntity = new Measurement();

        $measurmentEntity->setTemperature($celsius);
        $result = $measurmentEntity->getFahrenheit();
        if ($result == $expectedFahrenheit) {
            $this->assertTrue(true);
        }
    }
}
