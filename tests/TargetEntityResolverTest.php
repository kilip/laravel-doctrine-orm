<?php

namespace Tests\Kilip\LaravelDoctrine\ORM;

use Illuminate\Config\Repository as RepositoryConfig;
use Kilip\LaravelDoctrine\ORM\TargetEntityResolver;
use LaravelDoctrine\Extensions\Timestamps\TimestampableExtension;
use Tests\Kilip\LaravelDoctrine\ORM\TestCase;
use Tests\Kilip\LaravelDoctrine\ORM\Fixtures\Contracts\UserInterface;
use Tests\Kilip\LaravelDoctrine\ORM\Fixtures\Model\User;

class TargetEntityResolverTest extends TestCase
{
    protected function getEnvironmentSetUp($app)
    {
        parent::getEnvironmentSetUp($app);
    }

    public function testOnConstruct()
    {
        $config = $this->createMock(RepositoryConfig::class);
        $resolves = [
            UserInterface::class => User::class
        ];

        $config
            ->expects($this->once())
            ->method('get')
            ->with('doctrine.resolve_target_entities')
            ->willReturn($resolves);

        $resolver = new TargetEntityResolver($config);
    }
}
