<?php

namespace App\Command;

use App\Repository\LocationRepository;
use App\Service\WeatherUtil;
use Symfony\Component\Console\Attribute\Argument;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Style\SymfonyStyle;

#[AsCommand(
    name: 'weather:location',
    description: 'Add a short description for your command',
)]
class WeatherLocationCommand{
    public function __construct(
        private LocationRepository $locationRepository,
        private WeatherUtil $weatherUtil
    ) {}
    public function __invoke(
        SymfonyStyle $io,
        #[Argument('Location ID')] int $id,
    ): int {
        $location = $this->locationRepository->find($id);
        $measurements = $this->weatherUtil->getWeatherForLocation($location);

        $io->writeln(sprintf('Location: %s, %s (%s, %s)', $location->getCity(), $location->getCountry(), $location->getLatitude(), $location->getLongitude()));
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
