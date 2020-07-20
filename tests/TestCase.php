<?php


namespace Tests\Kilip\LaravelDoctrine\ORM;


use Kilip\LaravelDoctrine\ORM\KilipDoctrineServiceProvider;
use LaravelDoctrine\Extensions\GedmoExtensionsServiceProvider;
use LaravelDoctrine\ORM\DoctrineServiceProvider;
use Orchestra\Testbench\TestCase as OrchestraTestCase;

class TestCase extends OrchestraTestCase
{
    protected function getPackageProviders($app)
    {
        return [
            DoctrineServiceProvider::class,
            GedmoExtensionsServiceProvider::class,
            KilipDoctrineServiceProvider::class,
        ];
    }

    protected function getEnvironmentSetUp($app)
    {
        /* @var \Illuminate\Config\Repository $config */
        $config = $app['config'];

        $config->set('doctrine.managers.default.mappings',[
            __NAMESPACE__.'\\Fixtures\\Model' => [
                'paths' => [
                    __DIR__.'/Fixtures/Model'
                ]
            ]
        ]);

        $config->set('doctrine.managers.default.paths',[
            __DIR__.'/Fixtures/Resources/config'
        ]);
    }
}