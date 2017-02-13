<?php

/**
 * Install
 *
 * (The MIT license)
 * Copyright 2017 clickalicious UG, Benjamin Carl
 *
 * Permission is hereby granted, free of charge, to any person obtaining a
 * copy of this software and associated documentation files (the
 * "Software"), to deal in the Software without restriction, including
 * without limitation the rights to use, copy, modify, merge, publish,
 * distribute, sublicense, and/or sell copies of the Software, and to
 * permit persons to whom the Software is furnished to do so, subject to
 * the following conditions:
 *
 * The above copyright notice and this permission notice shall be
 * included in all copies or substantial portions of the Software.
 *
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND,
 * EXPRESS OR IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF
 * MERCHANTABILITY, FITNESS FOR A PARTICULAR PURPOSE AND
 * NONINFRINGEMENT. IN NO EVENT SHALL THE AUTHORS OR COPYRIGHT HOLDERS
 * BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER LIABILITY, WHETHER IN AN
 * ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM, OUT OF OR IN
 * CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE
 * SOFTWARE.
 *
 * @package    Install
 * @subpackage Install\Console
 */

namespace Install\Composer;

use PHPUnit\Framework\TestCase;

/**
 * Class ScriptHandlerTest
 *
 * @package Install\Composer
 * @author  Benjamin Carl <opensource@clickalicious.de>
 */
class ScriptHandlerTest extends TestCase
{
    /**
     * @var \Composer\Script\Event
     */
    private $event;

    /**
     * @var \Composer\IO\IOInterface
     */
    private $io;

    /**
     * @var \Composer\Package\PackageInterface
     */
    private $package;

    /**
     * setUp.
     *
     * @author Benjamin Carl <opensource@clickalicious.de>
     *
     */
    protected function setUp()
    {
        parent::setUp();

        $this->event   = $this->prophesize('Composer\Script\Event');
        $this->io      = $this->prophesize('Composer\IO\IOInterface');
        $this->package = $this->prophesize('Composer\Package\PackageInterface');

        /* @var $composer \Composer\Composer */
        $composer = $this->prophesize('Composer\Composer');

        $composer->getPackage()->willReturn($this->package);
        $this->event->getComposer()->willReturn($composer);
        $this->event->getIO()->willReturn($this->io);
    }

    /**
     * @param array  $extras           Parameters for installer.
     * @param string $exceptionMessage Message of exception
     *
     * @dataProvider provideInvalidConfiguration
     */
    public function testInvalidConfiguration(array $extras, $exceptionMessage)
    {
        $this->package->getExtra()->willReturn($extras);

        chdir(dirname(__DIR__, 2));

        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage($exceptionMessage);

        ScriptHandler::installFiles($this->event->reveal());
    }

    /**
     * provideInvalidConfiguration.
     *
     * @author Benjamin Carl <opensource@clickalicious.de>
     *
     * @return array
     */
    public function provideInvalidConfiguration()
    {
        return [
            'no install-parameters defined' => [
                [],
                ScriptHandler::ERROR_PARAMETERS_MISSING,
            ],
            'invalid type for install-parameters found' => [
                ['install-parameters' => 'not an array'],
                ScriptHandler::ERROR_PARAMETERS_INVALID_TYPE,
            ],
            'invalid type for single install-parameters set found' => [
                ['install-parameters' => ['not an array']],
                ScriptHandler::ERROR_PARAMETER_SET_INVALID_TYPE,
            ],
            'no file-uri passed with parameters' => [
                ['install-parameters' => []],
                ScriptHandler::ERROR_REQUIRED_PARAMETERS_MISSING
            ],
        ];
    }
}
