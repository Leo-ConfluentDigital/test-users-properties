<?php

namespace App\class;

class User
{
    private string $name;
    private string $lastName;
    private string $email;
    private string $phone;

    /**
     * @param string $name
     * @param string $lastName
     * @param string $email
     * @param string $phone
     */
    public function __construct(string $name, string $lastName, string $email, string $phone)
    {
        $this->name = $name;
        $this->lastName = $lastName;
        $this->email = $email;
        $this->phone = $phone;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): void
    {
        $this->name = $name;
    }

    public function getLastName(): string
    {
        return $this->lastName;
    }

    public function setLastName(string $lastName): void
    {
        $this->lastName = $lastName;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function setEmail(string $email): void
    {
        $this->email = $email;
    }

    public function getPhone(): string
    {
        return $this->phone;
    }

    public function setPhone(string $phone): void
    {
        $this->phone = $phone;
    }

}