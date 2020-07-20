<?php

namespace Tests\Kilip\LaravelDoctrine\ORM\Features;

use Kilip\LaravelDoctrine\ORM\MetadataConfigurator;
use Tests\Kilip\LaravelDoctrine\ORM\Fixtures\XML\TestXML;
use Tests\Kilip\LaravelDoctrine\ORM\TestCase;

class XMLMappingTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();
        $this->artisan('doctrine:schema:create');
    }

    protected function getEnvironmentSetUp($app)
    {
        parent::getEnvironmentSetUp($app);

        $app['config']->set('doctrine.managers.default.mappings',[
            'Tests\\Kilip\\LaravelDoctrine\\ORM\\Fixtures\\XML' => [
                'type' => 'xml',
                'dir' => realpath(__DIR__.'/../Fixtures/Resources/config')
            ]
        ]);
    }

    public function testLoad()
    {
        $object = new TestXML();
        $object->setName('test');
        $em = $this->app->make('registry')->getManager();
        $em->persist($object);
        $em->flush();

        $this->assertNotNull($object->getId());
    }
}
