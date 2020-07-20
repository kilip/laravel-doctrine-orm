<?php


namespace Tests\Kilip\LaravelDoctrine\ORM\Fixtures\Contracts;


interface UserInterface
{
    /**
     * @param string $username
     * @return static
     */
    public function setUsername(string $username);

    /**
     * @return string
     */
    public function getUsername();

    /**
     * @param string $password
     * @return static
     */
    public function setPassword(string $password);

    /**
     * @return string
     */
    public function getPassword();
}