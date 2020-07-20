<?php


namespace Kilip\LaravelDoctrine\ORM;


use Illuminate\Contracts\Foundation\Application;
use Illuminate\Support\ServiceProvider;
use LaravelDoctrine\ORM\BootChain;
use LaravelDoctrine\ORM\EntityManagerFactory as BaseEntityManagerFactory;
use LaravelDoctrine\ORM\IlluminateRegistry;

class KilipDoctrineServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $this->app->singleton(MetadataConfigurator::class, MetadataConfigurator::class);
        BootChain::add([$this,'handleOnDoctrineBoot']);
    }

    public function register()
    {
    }

    public function handleOnDoctrineBoot(IlluminateRegistry $registry)
    {
        $configurator = $this->app->make(MetadataConfigurator::class);

        foreach($registry->getManagerNames() as $managerName){
            $manager = $registry->getManager($managerName);
            $configurator->configure($managerName,$manager);
        }
    }
}