<?php

namespace app\entities;

/**
 * Entity объявления автомобиля.
 * Хранит основные данные объявления и техническую характеристику автомобиля.
 */
class Car
{

    private ?int $id = null;

    private string $title;
    private string $description;
    private float $price;
    private string $photoUrl;
    private string $contacts;

    private \DateTime $createdAt;

    private ?CarOption $option = null;

    public function __construct(
        string    $title,
        string    $description,
        float     $price,
        string    $photoUrl,
        string    $contacts,
        \DateTime $createdAt
    )
    {
        $this->title = $title;
        $this->description = $description;
        $this->price = $price;
        $this->photoUrl = $photoUrl;
        $this->contacts = $contacts;
        $this->createdAt = $createdAt;
    }

    public function addOption(CarOption $option): void
    {
        $this->option = $option;
    }

    public function setOption(CarOption $option): void
    {
        $this->option = $option;
    }

    public function getOption(): ?CarOption
    {
        return $this->option;
    }

    public function setId(int $id): void
    {
        $this->id = $id;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function getDescription(): string
    {
        return $this->description;
    }

    public function getPrice(): float
    {
        return $this->price;
    }

    public function getPhotoUrl(): string
    {
        return $this->photoUrl;
    }

    public function getContacts(): string
    {
        return $this->contacts;
    }

    public function getCreatedAt(): \DateTime
    {
        return $this->createdAt;
    }

}