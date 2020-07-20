<?php

/*
 * This file is part of the Omed project.
 *
 * (c) Anthonius Munthi <https://itstoni.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Tests\Kilip\LaravelDoctrine\ORM\Fixtures\Model;

use Doctrine\ORM\Mapping as ORM;
use Tests\Kilip\LaravelDoctrine\ORM\Fixtures\ModelClassTrait;

/**
 * Class TestAnnotation.
 *
 * @ORM\Entity
 */
class TestAnnotation
{
    use ModelClassTrait;

    /**
     * @ORM\Column(type="string")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="UUID")
     *
     * @var string
     */
    protected $id;

    /**
     * @ORM\Column(type="string")
     *
     * @var string
     */
    protected $name;
}
