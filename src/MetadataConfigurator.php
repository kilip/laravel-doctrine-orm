<?php


namespace Kilip\LaravelDoctrine\ORM;


use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Mapping\Driver\AnnotationDriver;
use Doctrine\ORM\Mapping\Driver\SimplifiedXmlDriver;
use Doctrine\ORM\Mapping\Driver\SimplifiedYamlDriver;
use Doctrine\ORM\Mapping\Driver\XmlDriver;

use Illuminate\Contracts\Config\Repository as RepositoryConfig;

class MetadataConfigurator
{
    /**
     * @var RepositoryConfig
     */
    private $repository;

    public function __construct(RepositoryConfig $repository)
    {
        $this->repository = $repository;
    }

    /**
     * @param string $name
     * @param EntityManagerInterface $manager
     * @throws \Doctrine\ORM\ORMException on ::getMetadataDriverImpl
     */
    public function configure(string $name, EntityManagerInterface $manager)
    {
        /* @var \LaravelDoctrine\ORM\Extensions\MappingDriverChain $chainDriver */
        $config = $this->repository;
        $chainDriver = $manager->getConfiguration()->getMetadataDriverImpl();
        $configKey = 'doctrine.managers.'.$name.'.mappings';
        $settings = $config->get($configKey);

        foreach($settings as $namespace => $setting)
        {
            $type = isset($setting['type']) ? $setting['type']:'annotation';
            $dir = $setting['dir'];
            $fileExtension = isset($setting['file_extension']) ? $setting['file_extension']:null;
            $driver = null;

            if('annotation' === $type){
                $path = $setting['dir'];
                $chainDriver->addPaths([$path]);
            }else{
                if('xml' === $type){
                    $fileExtension = is_null($fileExtension) ? SimplifiedXmlDriver::DEFAULT_FILE_EXTENSION:$fileExtension;
                    $driver = new SimplifiedXmlDriver([$dir => $namespace], $fileExtension);
                }
                elseif('yaml' === $type || 'yml' === $type){
                    $fileExtension = is_null($fileExtension) ? SimplifiedYamlDriver::DEFAULT_FILE_EXTENSION:$fileExtension;
                    $driver = new SimplifiedYamlDriver($dir,$fileExtension);
                }else{
                    throw new \InvalidArgumentException(
                        sprintf('Unknown doctrine mapping type "%s"',$type)
                    );
                }
                $chainDriver->addDriver($driver, $namespace);
            }
        }
    }
}