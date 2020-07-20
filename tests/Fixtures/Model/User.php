<?php


namespace Tests\Kilip\LaravelDoctrine\ORM\Fixtures\Model;

use Doctrine\ORM\Mapping as ORM;
use Tests\Kilip\LaravelDoctrine\ORM\Fixtures\Contracts\UserInterface;

/**
 * Class User
 *
 * @ORM\Entity()
 * @ORM\Table(name="test_user")
 *
 * @package Tests\Kilip\LaravelDoctrine\ORM\Fixtures\Model
 */
class User implements UserInterface
{
    /**
     * @ORM\Column(type="string")
     * @ORM\Id()
     * @ORM\GeneratedValue(strategy="UUID")
     *
     * @var string
     */
    private $id;

    /**
     * @ORM\Column(type="string")
     *
     * @var string
     */
    private $username;

    /**
     * @ORM\Column(type="string")
     *
     * @var string
     */
    private $password;

    /**
     * @return string
     */
    public function getId(): string
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getUsername(): string
    {
        return $this->username;
    }

    /**
     * @param string $username
     * @return User
     */
    public function setUsername(string $username): User
    {
        $this->username = $username;
        return $this;
    }

    /**
     * @return string
     */
    public function getPassword(): string
    {
        return $this->password;
    }

    /**
     * @param string $password
     * @return User
     */
    public function setPassword(string $password): User
    {
        $this->password = $password;
        return $this;
    }
}