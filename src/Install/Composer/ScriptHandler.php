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
 */

namespace Install\Composer;

use Composer\Script\Event;

/**
 * Class ScriptHandler
 *
 * @package Install\Composer
 * @author  Benjamin Carl <opensource@clickalicious.de>
 */
class ScriptHandler
{
    /**
     * Error: No configuration passed.
     *
     * @var string
     */
    const ERROR_PARAMETERS_MISSING = 'The installer needs to be configured through the extra.install-parameters setting.';

    /**
     * Error: Type neither array nor object.
     *
     * @var string
     */
    const ERROR_PARAMETERS_INVALID_TYPE = 'The extra.install-parameters setting must be an array of configuration objects.';

    /**
     * Error: Single set of parameters invalid type.
     *
     * @var string
     */
    const ERROR_PARAMETER_SET_INVALID_TYPE = 'An extra.install-parameters[] set must be an array.';

    /**
     * Error: Required parameter(s) missing.
     *
     * @var string
     */
    const ERROR_REQUIRED_PARAMETERS_MISSING = 'The extra.install-parameters.file-uri setting is required to use this script handler.';

    /**
     * installFiles handles the call for file installation from composer.json
     *
     * @param \Composer\Script\Event $event
     *
     * @author Benjamin Carl <opensource@clickalicious.de>
     *
     * @throws \InvalidArgumentException On any exceptional behavior.
     * @throws \RuntimeException
     */
    public static function installFiles(Event $event)
    {
        $extras = $event->getComposer()->getPackage()->getExtra();

        // Prepare composer environment defaults for interpolation
        $composerBinDir = $event->getComposer()->getConfig()->get('bin-dir');

        // Check if required installer parameters defined
        if (false === isset($extras['install-parameters'])) {
            throw new \InvalidArgumentException(self::ERROR_PARAMETERS_MISSING);
        }

        $configs = $extras['install-parameters'];

        // Check if type is correct
        if (false === is_array($configs)) {
            throw new \InvalidArgumentException(self::ERROR_PARAMETERS_INVALID_TYPE);
        }

        if (array_keys($configs) !== range(0, count($configs) - 1)) {
            $configs = array($configs);
        }

        // Retrieve script processor handle (responsive for reading parameters and dispatching download & install)
        $processor = new ScriptProcessor($event->getIO());

        // Iterate configurations found and process

        foreach ($configs as $config) {

            if (false === is_array($config)) {
                throw new \InvalidArgumentException(self::ERROR_PARAMETER_SET_INVALID_TYPE);
            }

            if (!array_key_exists('file-uri', $config)) {
                throw new \InvalidArgumentException(self::ERROR_REQUIRED_PARAMETERS_MISSING);
            }

            $processor->processFile(
                $config,
                $composerBinDir
            );
        }
    }
}
