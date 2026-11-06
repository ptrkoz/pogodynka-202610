<?php

namespace App\Command;

use App\Service\WeatherUtil;
use Symfony\Component\Console\Attribute\Argument;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Style\SymfonyStyle;

#[AsCommand(
    name: 'weather:country_city',
    description: 'Add a short description for your command',
)]
class WeatherCountryCityCommand{
    public function __construct(
        private WeatherUtil $weatherUtil
    ) {}
    public function __invoke(
        SymfonyStyle $io,
        #[Argument('Country code')] string $country,
        #[Argument('City')] string $city,
    ): int {
        $measurements = $this->weatherUtil->getWeatherForCountryAndCity($country, $city);

        $io->table(['Date', 'Temperature [°C]', 'Humidity [%]', 'Precipitation [%]', 'Wind [km/h]'], array_map(fn($m) => [
            date('d/m/Y', $m->getTimestamp()),
            $m->getTemperature(),
            $m->getHumidity(),
            $m->getPrecipitation(),
            $m->getWind(),
        ], $measurements));

        return Command::SUCCESS;
    }
}
