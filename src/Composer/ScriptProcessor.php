<?php

/**
 * (The MIT license)
 * Copyright 2017 clickalicious, Benjamin Carl
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

namespace Clickalicious\Install\Composer;

use Composer\Script\Event;

/**
 * Class ScriptProcessor
 *
 * @package Install\Composer
 * @author  Benjamin Carl <opensource@clickalicious.de>
 */
class ScriptProcessor
{
    /**
     * processFile.
     *
     * @param array  $configuration  Configuration set passed by Composer run.
     * @param string $composerBinDir Binary directory (e.g. vendor/bin) used by Composer.
     *
     * @author Benjamin Carl <opensource@clickalicious.de>
     *
     * @throws \InvalidArgumentException On any exceptional behavior.
     */
    public function processFile(array $configuration, $composerBinDir)
    {
        $configuration = $this->interpolateConfiguration($configuration);

        $fileUri      = $configuration['file-uri'];
        $parameterKey = $configuration['parameter-key'];

        //$exists = is_file($realFile);
        //$action = $exists ? 'Updating' : 'Creating';
        //$this->io->write(sprintf('<info>%s the "%s" file</info>', $action, $realFile));
    }

    /**
     * Fills the gaps in configuration with empty placeholders
     *
     * @param array $configuration
     *
     * @return array
     *
     * @throws \InvalidArgumentException
     */
    protected function interpolateConfiguration(array $configuration)
    {
        if (empty($configuration['dist-file'])) {
            $configuration['dist-file'] = $configuration['file'].'.dist';
        }

        if (!is_file($configuration['dist-file'])) {
            throw new \InvalidArgumentException(sprintf('The dist file "%s" does not exist. Check your dist-file config or create it.', $configuration['dist-file']));
        }

        if (empty($configuration['parameter-key'])) {
            $configuration['parameter-key'] = 'parameters';
        }

        return $configuration;
    }
}
