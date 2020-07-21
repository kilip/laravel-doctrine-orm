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

namespace Kilip\LaravelDoctrine\ORM\Testing;

use Doctrine\ORM\Tools\SchemaTool;
use Doctrine\ORM\Tools\ToolsException;
use LaravelDoctrine\ORM\IlluminateRegistry;

trait ORMTestTrait
{
    protected function recreateDatabase()
    {
        $registry = $this->getIlluminateRegistry();

        foreach ($registry->getManagers() as $manager) {
            $meta = $manager->getMetadataFactory()->getAllMetadata();
            $tool = new SchemaTool($manager);
            try {
                $tool->dropSchema($meta);
                $tool->createSchema($meta);
            } catch (ToolsException $e) {
                throw new \InvalidArgumentException("Database schema is not buildable: {$e->getMessage()}", $e->getCode(), $e);
            }
        }
    }

    /**
     * Store changes into database.
     *
     * @param object $entity
     * @param bool   $andFlush
     */
    protected function store(object $entity, $andFlush = true)
    {
        $class = \get_class($entity);
        $manager = $this->getManagerForClass($class);

        $manager->persist($entity);
        if ($andFlush) {
            $manager->flush();
        }
    }

    /**
     * @param string $className
     *
     * @return \Doctrine\Persistence\ObjectRepository
     */
    protected function getRepository(string $className)
    {
        return $this->getManagerForClass($className)->getRepository($className);
    }

    /**
     * @param string $className
     *
     * @return \Doctrine\Persistence\ObjectManager|null
     */
    protected function getManagerForClass(string $className)
    {
        $manager = $this->getIlluminateRegistry()->getManagerForClass($className);
        if (null === $manager) {
            throw new \InvalidArgumentException(sprintf('There are no manager found for "%s" class.'));
        }

        return $this->getIlluminateRegistry()->getManagerForClass($className);
    }

    /**
     * @return IlluminateRegistry
     */
    protected function getIlluminateRegistry()
    {
        return app()->get('registry');
    }
}
