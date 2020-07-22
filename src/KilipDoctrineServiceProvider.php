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

namespace Kilip\LaravelDoctrine\ORM;

use Illuminate\Support\ServiceProvider;
use LaravelDoctrine\ORM\BootChain;
use LaravelDoctrine\ORM\IlluminateRegistry;

class KilipDoctrineServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $this->app->singleton(MetadataConfigurator::class, MetadataConfigurator::class);
        BootChain::add([$this, 'handleOnDoctrineBoot']);
    }

    public function register()
    {
        config([
            'doctrine.extensions' => array_merge(
                [TargetEntityResolver::class], config('doctrine.extensions', [])
            ),
        ]);
        config([
            'doctrine.managers.default.mappings' => array_merge([], config('doctrine.managers.default.mappings', [])),
        ]);
    }

    public function handleOnDoctrineBoot(IlluminateRegistry $registry)
    {
        $configurator = $this->app->make(MetadataConfigurator::class);

        foreach ($registry->getManagerNames() as $managerName) {
            $manager = $registry->getManager($managerName);
            $configurator->configure($managerName, $manager);
        }
    }
}
