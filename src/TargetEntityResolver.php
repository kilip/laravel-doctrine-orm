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

use Doctrine\Common\Annotations\Reader;
use Doctrine\Common\EventManager;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Tools\ResolveTargetEntityListener;
use Illuminate\Config\Repository as RepositoryConfig;
use LaravelDoctrine\ORM\Extensions\Extension as ExtensionContract;

class TargetEntityResolver extends ResolveTargetEntityListener implements ExtensionContract
{
    public function __construct(RepositoryConfig $config)
    {
        $resolves = $config->get('doctrine.resolve_target_entities', []);
        foreach ($resolves as $abstract => $concrete) {
            $this->addResolveTargetEntity($abstract, $concrete, []);
        }
    }

    public function addSubscribers(EventManager $manager, EntityManagerInterface $em, Reader $reader = null)
    {
        $manager->addEventSubscriber($this);
    }

    public function getFilters()
    {
        return [];
    }
}
