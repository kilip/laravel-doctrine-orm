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

use Tests\Kilip\LaravelDoctrine\ORM\Fixtures\PHP\TestPHP;
use Tests\Kilip\LaravelDoctrine\ORM\TestCase;

class PHPMappingTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();
        $this->artisan('doctrine:schema:create');
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

        $em = $this->app->make('em');
        $em->persist($object);
        $em->flush();

        $this->assertNotNull($object->getId());
    }
}
