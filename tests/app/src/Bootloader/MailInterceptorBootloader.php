<?php

/**
 * Spiral Framework.
 *
 * @license   MIT
 * @author    Anton Titov (Wolfy-J)
 */

declare(strict_types=1);

namespace Spiral\App\Bootloader;

use Spiral\App\MailInterceptor;
use Spiral\Boot\Bootloader\Bootloader;
use Symfony\Component\Mailer\MailerInterface;

class MailInterceptorBootloader extends Bootloader
{
    protected const SINGLETONS = [
        MailerInterface::class => MailInterceptor::class,
    ];
}
