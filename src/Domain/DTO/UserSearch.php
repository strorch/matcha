<?php


namespace App\Domain\DTO;


final class UserSearch
{
    /** @var string|null */
    private $login;

    /** @var string|null */
    private $password;

    /** @var string|null */
    private $additionalPassword;

    /** @var string|null */
    private $location;

    /**
     * @param string $login
     * @return UserSearch
     */
    public function setLogin(string $login): self
    {
        $this->login = $login;

        return $this;
    }

    /**
     * @param string $password
     * @return UserSearch
     */
    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    /**
     * @param string $location
     * @return UserSearch
     */
    public function setLocation(string $location): self
    {
        $this->location = $location;

        return $this;
    }

    /**
     * @return string
     */
    public function getLogin(): string
    {
        return $this->login;
    }

    /**
     * @return string|null
     */
    public function getLocation(): ?string
    {
        return $this->location;
    }

    /**
     * @return string|null
     */
    public function getAdditionalPassword(): ?string
    {
        return $this->additionalPassword;
    }

    /**
     * @param string $additionalPassword
     * @return UserSearch
     */
    public function setAdditionalPassword(string $additionalPassword): self
    {
        $this->additionalPassword = $additionalPassword;

        return $this;
    }
}