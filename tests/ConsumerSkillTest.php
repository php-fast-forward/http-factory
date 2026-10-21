<?php

declare(strict_types=1);

/**
 * Fast Forward PSR-7 HTTP Factory utility classes.
 *
 * This file is part of fast-forward/http-factory project.
 *
 * @author   Felipe Sayão Lobato Abreu <github@mentordosnerds.com>
 * @license  https://opensource.org/licenses/MIT MIT License
 *
 * @see      https://php-fast-forward.github.io/http-factory/
 * @see      https://github.com/php-fast-forward/http-factory
 * @see      https://github.com/php-fast-forward/http-factory/issues
 * @see      https://datatracker.ietf.org/doc/html/rfc2119
 */

namespace FastForward\Http\Message\Factory\Tests;

use PHPUnit\Framework\Attributes\CoversNothing;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Process\Process;

#[CoversNothing]
final class ConsumerSkillTest extends TestCase
{
    /**
     * @return void
     */
    public function testBundledConsumerIntegration(): void
    {
        $root = \dirname(__DIR__);
        $process = new Process([
            \PHP_BINARY,
            $root . '/resources/skills/fast-forward-http-factory/examples/integration.php',
            $root . '/vendor/autoload.php',
        ], $root, [
            'XDEBUG_MODE' => 'off',
        ]);
        $process->setTimeout(20);
        $process->run();

        self::assertTrue($process->isSuccessful(), $process->getErrorOutput() . $process->getOutput());
        self::assertStringContainsString('fast-forward-http-factory: ok', $process->getOutput());
    }
}
