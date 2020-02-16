<?php


namespace App\Domain\DTO;


final class ClientSearch
{
    /** @var string[] */
    private $logins = [];

    /** @var string|null */
    private $location;

    /**
     * @param string $login
     * @return ClientSearch
     */
    public function addLogin(string $login): self
    {
        $this->logins[] = $login;

        return $this;
    }

    /**
     * @param string $location
     * @return ClientSearch
     */
    public function setLocation(string $location): self
    {
        $this->location = $location;

        return $this;
    }

    /**
     * @return string[]
     */
    public function getLogins(): array
    {
        return $this->logins;
    }

    /**
     * @return string|null
     */
    public function getLocation(): ?string
    {
        return $this->location;
    }
}