<?php


namespace Tests\Kilip\LaravelDoctrine\ORM\Fixtures\Model;


use Doctrine\ORM\Mapping as ORM;

/**
 * Class TestAnnotation
 *
 * @ORM\Entity()
 * @package Tests\Kilip\LaravelDoctrine\ORM\Fixtures\Model
 */
class TestAnnotation
{
    /**
     * @ORM\Column(type="string")
     * @ORM\Id()
     * @ORM\GeneratedValue(strategy="UUID")
     * @var string
     */
    protected $id;

    /**
     * @var string
     */
    protected $name;

    /**
     * @return string
     */
    public function getId(): string
    {
        return $this->id;
    }

    /**
     * @param string $id
     */
    public function setId(string $id): void
    {
        $this->id = $id;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @param string $name
     */
    public function setName(string $name): void
    {
        $this->name = $name;
    }
}