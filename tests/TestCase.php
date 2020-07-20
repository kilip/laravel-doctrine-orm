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

namespace Tests\Kilip\LaravelDoctrine\ORM;

use Kilip\LaravelDoctrine\ORM\KilipDoctrineServiceProvider;
use LaravelDoctrine\Extensions\GedmoExtensionsServiceProvider;
use LaravelDoctrine\ORM\DoctrineServiceProvider;
use Orchestra\Testbench\TestCase as OrchestraTestCase;

class TestCase extends OrchestraTestCase
{
    /**
     * @var array
     */
    public static $annotationConfig = [
        __NAMESPACE__.'\\Fixtures\\Model' => [
            'dir' => __DIR__.'/Fixtures/Model',
        ],
    ];

    public static $xmlConfig = [
        __NAMESPACE__.'\\Fixtures\\XML' => [
            'dir' => __DIR__.'/Fixtures/Resources/config',
            'type' => 'xml',
        ],
    ];

    public static $ymlConfig = [
        __NAMESPACE__.'\\Fixtures\\YML' => [
            'dir' => __DIR__.'/Fixtures/Resources/config',
            'type' => 'yml',
        ],
    ];

    public static $phpConfig = [
        __NAMESPACE__.'\\Fixtures\\PHP' => [
            'dir' => __DIR__.'/Fixtures/Resources/config',
            'type' => 'php',
        ],
    ];

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
        /** @var \Illuminate\Config\Repository $config */
        $config = $app['config'];

        $config->set('doctrine.managers.default.mappings', [
            __NAMESPACE__.'\\Fixtures\\Model' => [
                'paths' => [
                    __DIR__.'/Fixtures/Model',
                ],
            ],
        ]);

        $config->set('doctrine.managers.default.paths', [
            __DIR__.'/Fixtures/Resources/config/foo',
        ]);
    }
}
