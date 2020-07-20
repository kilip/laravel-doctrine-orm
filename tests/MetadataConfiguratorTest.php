<?php

namespace Tests\Kilip\LaravelDoctrine\ORM;

use Doctrine\ORM\Configuration;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Mapping\Driver\SimplifiedXmlDriver;
use Illuminate\Contracts\Config\Repository;
use Kilip\LaravelDoctrine\ORM\MetadataConfigurator;
use LaravelDoctrine\ORM\Extensions\MappingDriverChain;
use PHPUnit\Framework\TestCase;

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

    /**
     * @var array
     */
    private $annotationConfig = [
        __NAMESPACE__.'\\Fixtures\\Model' => [
            'dir' => __DIR__.'/Fixtures/Model'
        ],
    ];

    private $xmlConfig = [
        __NAMESPACE__.'\\Fixtures\\XML' => [
            'dir' => __DIR__.'/Fixtures/Resources/config/xml',
            'type' => 'xml'
        ],
    ];

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
        $settings = $this->annotationConfig;

        $repository->expects($this->once())
            ->method('get')
            ->with('doctrine.managers.default.mappings')
            ->willReturn($settings)
        ;

        $chainDriver->expects($this->once())
            ->method('addPaths')
            ->with([__DIR__.'/Fixtures/Model']);

        $configurator = new MetadataConfigurator($repository);
        $configurator->configure('default',$em);
    }

    public function testConfigureXML()
    {
        $em = $this->em;
        $repository = $this->repository;
        $chainDriver = $this->chainDriver;
        $settings = $this->xmlConfig;

        $repository->expects($this->once())
            ->method('get')
            ->with('doctrine.managers.default.mappings')
            ->willReturn($settings)
        ;

        $chainDriver->expects($this->once())
            ->method('addDriver')
            ->with(
                $this->isInstanceOf(SimplifiedXmlDriver::class),
                __NAMESPACE__.'\\Fixtures\\XML'
            );

        $configurator = new MetadataConfigurator($repository);
        $configurator->configure('default', $em);
    }
}
