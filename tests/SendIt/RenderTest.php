<?php

/**
 * Spiral Framework.
 *
 * @license   MIT
 * @author    Anton Titov (Wolfy-J)
 */

declare(strict_types=1);

namespace Spiral\SendIt\Tests;

use PHPUnit\Framework\TestCase;
use Spiral\App\App;
use Spiral\Mailer\Exception\MailerException;
use Spiral\Mailer\Message;

class RenderTest extends TestCase
{
    private $app;

    public function setUp(): void
    {
        $this->app = App::init([
            'root' => __DIR__ . '/..'
        ]);
    }

    public function testRenderError(): void
    {
        $this->expectException(MailerException::class);
        $email = $this->app->send(new Message('test', ['email@domain.com'], ['name' => 'Antony']));
    }

    public function testRender(): void
    {
        $email = $this->app->send(new Message('email', ['email@domain.com'], ['name' => 'Antony']));

        $this->assertSame('Demo Email', $email->getSubject());

        $body = $email->getBody()->toString();
        $this->assertStringContainsString('bootstrap.txt', $body);
        $this->assertStringContainsString('<p>Hello, Antony!</p>', $body);
    }
}
