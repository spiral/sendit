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
use Spiral\Mailer\Message;
use Spiral\SendIt\MessageSerializer;

class SerializerTest extends TestCase
{
    public function testSerializeUnserialize()
    {
        $mail = new Message("test", ['email@domain.com'], ['key' => 'value']);
        $mail->setFrom('admin@spiral.dev');
        $mail->setReplyTo('admin@spiral.dev');
        $mail->setCC('admin@google.com');
        $mail->setBCC('admin2@google.com');

        $data = MessageSerializer::pack($mail);

        $this->assertEquals($mail, MessageSerializer::unpack($data));
    }
}
