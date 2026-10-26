<?php

namespace App\Entity;

use App\Repository\MeasurementRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: MeasurementRepository::class)]
class Measurement
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'measurements')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Location $location = null;

    #[ORM\Column]
    private ?float $temperature = null;

    #[ORM\Column]
    private ?float $humidity = null;

    #[ORM\Column]
    private ?float $precipitation = null;

    #[ORM\Column]
    private ?float $wind = null;

    #[ORM\Column(length: 255)]
    private ?string $timestamp = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getLocation(): ?Location
    {
        return $this->location;
    }

    public function setLocation(?Location $location): static
    {
        $this->location = $location;

        return $this;
    }

    public function getTemperature(): ?float
    {
        return $this->temperature;
    }

    public function setTemperature(float $temperature): static
    {
        $this->temperature = $temperature;

        return $this;
    }

    public function getHumidity(): ?float
    {
        return $this->humidity;
    }

    public function setHumidity(float $humidity): static
    {
        $this->humidity = $humidity;

        return $this;
    }

    public function getPrecipitation(): ?float
    {
        return $this->precipitation;
    }

    public function setPrecipitation(float $precipitation): static
    {
        $this->precipitation = $precipitation;

        return $this;
    }

    public function getWind(): ?float
    {
        return $this->wind;
    }

    public function setWind(float $wind): static
    {
        $this->wind = $wind;

        return $this;
    }

    public function getTimestamp(): ?string
    {
        return $this->timestamp;
    }

    public function setTimestamp(string $timestamp): static
    {
        $this->timestamp = $timestamp;

        return $this;
    }
}
