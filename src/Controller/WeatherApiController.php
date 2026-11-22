<?php

namespace App\Controller;

use App\Entity\Measurement;
use App\Service\WeatherUtil;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Attribute\MapQueryParameter;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Serializer\Encoder\CsvEncoder;
use Symfony\Component\Serializer\SerializerInterface;

final class WeatherApiController extends AbstractController
{
    public function __construct(
        private WeatherUtil $weatherUtil,
        private SerializerInterface $serializer
    ) {}

    #[Route('/api/v1/weather', name: 'app_weather_api')]
    public function index(
        #[MapQueryParameter] string $city,
        #[MapQueryParameter] string $country,
        #[MapQueryParameter(filter: \FILTER_VALIDATE_REGEXP, options: ['regexp' => '/^(?:json|csv)$/'])] string $format = 'json',
        #[MapQueryParameter('twig')] bool $twig = false,
    ): Response
    {
        $measurements = $this->weatherUtil->getWeatherForCountryAndCity($country, $city);
        $measurementsArr = array_map(fn(Measurement $m) => [
            'city' => $city,
            'country' => $country,
            'date' => date('d/m/Y', $m->getTimestamp()),
            'celsius' => $m->getTemperature(),
            'fahrenheit' => $m->getFahrenheit(),
            'humidity' => $m->getHumidity(),
            'precipitation' => $m->getPrecipitation(),
            'wind' => $m->getWind(),
        ], $measurements);

        if ($format === 'json') {
            if ($twig === false) {
                return $this->json([
                    'measurements' => $measurementsArr
                ]);
            } else {
                $content = $this->renderView('weather_api/index.json.twig', [
                    'city' => $city,
                    'country' => $country,
                    'measurements' => $measurementsArr,
                ]);

                return new Response(
                    $content,
                    Response::HTTP_OK,
                    ['Content-Type' => 'application/json']
                );
            }

        } else {
            $csvContent = $this->serializer->serialize($measurementsArr, 'csv', [
                CsvEncoder::DELIMITER_KEY => ',',
                CSVEncoder::END_OF_LINE => "\r\n",
            ]);

            $response = new Response($csvContent,Response::HTTP_OK, ['Content-Type' => 'text/csv']);

            if ($twig === false) {
                return $response;
            } else {

                $content = $this->renderView('weather_api/index.csv.twig', [
                    'measurements' => $csvContent,
                ]);

                return new Response(
                    $content,
                    Response::HTTP_OK,
                    ['Content-Type' => 'text/csv']
                );
            }
        }
    }
}
