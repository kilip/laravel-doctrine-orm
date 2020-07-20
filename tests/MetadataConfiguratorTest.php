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

use Doctrine\ORM\Configuration;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Mapping\Driver\SimplifiedXmlDriver;
use Doctrine\ORM\Mapping\Driver\SimplifiedYamlDriver;
use Doctrine\Persistence\Mapping\Driver\PHPDriver;
use Illuminate\Contracts\Config\Repository;
use Kilip\LaravelDoctrine\ORM\MetadataConfigurator;
use LaravelDoctrine\ORM\Extensions\MappingDriverChain;

class MetadataConfiguratorTest extends TestCase
{
    /**
     * @var EntityManagerInterface|\PHPUnit\Framework\MockObject\MockObject
     */
    private $em;

    /**
     * @var Repository|\PHPUnit\Framework\MockObject\MockObject
     */
    private $repository;

    /**
     * @var MappingDriverChain|\PHPUnit\Framework\MockObject\MockObject
     */
    private $chainDriver;

    /**
     * @var Configuration|\PHPUnit\Framework\MockObject\MockObject
     */
    private $configuration;

    protected function setUp(): void
    {
        parent::setUp();

        $this->em = $this->createMock(EntityManagerInterface::class);
        $this->repository = $this->createMock(Repository::class);
        $this->chainDriver = $this->createMock(MappingDriverChain::class);
        $this->configuration = $this->createMock(Configuration::class);

        $this->em
            ->method('getConfiguration')
            ->willReturn($this->configuration);

        $this->configuration
            ->method('getMetadataDriverImpl')
            ->willReturn($this->chainDriver);
    }

    public function testConfigureAnnotation()
    {
        $em = $this->em;
        $repository = $this->repository;
        $chainDriver = $this->chainDriver;
        $settings = static::$annotationConfig;

        $repository->expects($this->once())
            ->method('get')
            ->with('doctrine.managers.default.mappings')
            ->willReturn($settings);

        $chainDriver->expects($this->once())
            ->method('addPaths')
            ->with([__DIR__.'/Fixtures/Model']);

        $configurator = new MetadataConfigurator($repository);
        $configurator->configure('default', $em);
    }

    public function testConfigureXML()
    {
        $em = $this->em;
        $repository = $this->repository;
        $chainDriver = $this->chainDriver;
        $settings = static::$xmlConfig;

        $repository->expects($this->once())
            ->method('get')
            ->with('doctrine.managers.default.mappings')
            ->willReturn($settings);

        $chainDriver->expects($this->once())
            ->method('addDriver')
            ->with(
                $this->isInstanceOf(SimplifiedXmlDriver::class),
                __NAMESPACE__.'\\Fixtures\\XML'
            );

        $configurator = new MetadataConfigurator($repository);
        $configurator->configure('default', $em);
    }

    public function testConfigureYml()
    {
        $em = $this->em;
        $repository = $this->repository;
        $chainDriver = $this->chainDriver;
        $settings = static::$ymlConfig;

        $repository->expects($this->once())
            ->method('get')
            ->with('doctrine.managers.default.mappings')
            ->willReturn($settings);

        $chainDriver->expects($this->once())
            ->method('addDriver')
            ->with(
                $this->isInstanceOf(SimplifiedYamlDriver::class),
                __NAMESPACE__.'\\Fixtures\\YML'
            );

        $configurator = new MetadataConfigurator($repository);
        $configurator->configure('default', $em);
    }

    public function testConfigurePHP()
    {
        $em = $this->em;
        $repository = $this->repository;
        $chainDriver = $this->chainDriver;
        $settings = static::$phpConfig;

        $repository->expects($this->once())
            ->method('get')
            ->with('doctrine.managers.default.mappings')
            ->willReturn($settings);

        $chainDriver->expects($this->once())
            ->method('addDriver')
            ->with(
                $this->isInstanceOf(PHPDriver::class),
                __NAMESPACE__.'\\Fixtures\\PHP'
            );

        $configurator = new MetadataConfigurator($repository);
        $configurator->configure('default', $em);
    }

    public function testWithInvalidType()
    {
        $em = $this->em;
        $repository = $this->repository;
        $settings = [
            __NAMESPACE__.'\\Fixtures\\PHP' => [
                'dir' => __DIR__.'/Fixtures/Resources/config',
                'type' => 'foo',
            ],
        ];

        $repository->expects($this->once())
            ->method('get')
            ->with('doctrine.managers.default.mappings')
            ->willReturn($settings);

        $this->expectException(\InvalidArgumentException::class);
        $configurator = new MetadataConfigurator($repository);
        $configurator->configure('default', $em);
    }
}
