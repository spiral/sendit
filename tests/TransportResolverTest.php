<?php

declare(strict_types=1);

namespace Spiral\Tests\SendIt;

use Mockery as m;
use Mockery\Adapter\Phpunit\MockeryPHPUnitIntegration;
use PHPUnit\Framework\TestCase;
use Spiral\SendIt\TransportResolver;
use Symfony\Component\Mailer\Exception\UnsupportedSchemeException;
use Symfony\Component\Mailer\Transport;
use Symfony\Component\Mailer\Transport\TransportFactoryInterface;

final class TransportResolverTest extends TestCase
{
    use MockeryPHPUnitIntegration;

    public function testCanRegisterTransport(): void
    {
        $transportFactory = m::mock(TransportFactoryInterface::class);
        $transportResolver = new TransportResolver(new Transport([]));

        $transportResolver->registerTransport($transportFactory);
        $this->assertCount(1, $transportResolver->getTransports());
    }

    public function testCanResolveRegisteredTransport(): void
    {
        $transportFactory = m::mock(TransportFactoryInterface::class);
        $arg = fn(Transport\Dsn $dsn) => $dsn->getHost() === 'localhost' and $dsn->getScheme() === 'smtp';

        $transportFactory->shouldReceive('supports')->once()->withArgs($arg)->andReturn(true);
        $transportFactory->shouldReceive('create')->once()->withArgs($arg)
            ->andReturn($transport = m::mock(Transport\TransportInterface::class));

        $transportResolver = new TransportResolver(new Transport([]));

        $transportResolver->registerTransport($transportFactory);

        $this->assertSame($transport, $transportResolver->resolve('smtp://localhost'));
    }

    public function testCanResolveRegisteredDefaultTransport(): void
    {
        $transportFactory = m::mock(TransportFactoryInterface::class);
        $arg = fn(Transport\Dsn $dsn) => $dsn->getHost() === 'localhost' and $dsn->getScheme() === 'smtp';

        $transportFactory->shouldReceive('supports')->once()->withArgs($arg)->andReturn(true);
        $transportFactory->shouldReceive('create')->once()->withArgs($arg)
            ->andReturn($transport = m::mock(Transport\TransportInterface::class));

        $transportResolver = new TransportResolver(new Transport([$transportFactory]));

        $this->assertSame($transport, $transportResolver->resolve('smtp://localhost'));
    }

    public function testNotRegisteredTransportShouldTrowAnException(): void
    {
        $this->expectException(UnsupportedSchemeException::class);
        $this->expectExceptionMessage('The "smtp" scheme is not supported.');
        $transportFactory = m::mock(TransportFactoryInterface::class);

        $transportFactory->shouldReceive('supports')->once()->andReturn(false);
        $transportResolver = new TransportResolver(new Transport([]));
        $transportResolver->registerTransport($transportFactory);
        $transportResolver->resolve('smtp://localhost');
    }
}
