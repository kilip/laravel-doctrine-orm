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

namespace Tests\Kilip\LaravelDoctrine\ORM\Features;

use Kilip\LaravelDoctrine\ORM\Testing\ORMTestTrait;
use Tests\Kilip\LaravelDoctrine\ORM\Fixtures\PHP\TestPHP;
use Tests\Kilip\LaravelDoctrine\ORM\TestCase;

class PHPMappingTest extends TestCase
{
    use ORMTestTrait;

    protected function setUp(): void
    {
        parent::setUp();
        $this->recreateDatabase();
    }

    protected function getEnvironmentSetUp($app)
    {
        parent::getEnvironmentSetUp($app);

        $app['config']->set('doctrine.managers.default.mappings', static::$phpConfig);
    }

    public function testLoad()
    {
        $object = new TestPHP();
        $object->setName('test');

        $this->store($object);

        $this->assertNotNull($object->getId());
    }
}
