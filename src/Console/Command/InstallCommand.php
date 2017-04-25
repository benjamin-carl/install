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

namespace Clickalicious\Install\Console\Command;

use Install\File\Installer;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Exception\InvalidArgumentException;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * Class InstallCommand
 *
 * @package Install\Console\Command
 * @author  Benjamin Carl <opensource@clickalicious.de>
 */
class InstallCommand extends Command
{
    /**
     * Configuration
     *
     * @return void
     *
     * @throws InvalidArgumentException
     */
    protected function configure()
    {
        $this->setName('file:install')
             ->setDescription('The install command installs a binary (binary, shell, phar) to local operating system and makes it globally available.')
             ->setDefinition([
                 new InputArgument(
                     'file-name', InputArgument::REQUIRED, 'File name and path being installed.'
                 ),
                 new InputArgument(
                     'destination-path', InputArgument::OPTIONAL, 'Destination path to install file to.'
                 ),
                 new InputOption(
                     'changemod', 'cm', InputOption::VALUE_OPTIONAL, 'Flag to make file executable with chmod.', 00001
                 )
             ])
             ->setHelp('The <info>install</info> command installs/registers a file from local filesystem in OS.');
    }

    /**
     * Executes the command
     *
     * @param InputInterface  $input
     * @param OutputInterface $output
     *
     * @return int|null|void
     *
     * @throws InvalidArgumentException
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $fileName        = $input->getArgument('file-name');
        $destinationPath = $input->getArgument('destination-path');

        $chmodExcecutable = $input->getOption('changemod');


        dump($chmodExcecutable);
        die;

        /*
        $operatingSystem = strtolower(php_uname('s'));

        $installer = new Installer(
            new Installer\InstallerFactory($operatingSystem)
        );

        // Start install
        if (true !== $result = $installer->install($fileName)) {
            $output->writeln(
                sprintf('<error>Error "%s" while installing file "%s".</error>', $result, $fileName)
            );

        } else {
            $output->writeln(
                sprintf(
                    '<info>File "%s" installed successful.</info>',
                    $fileName
                )
            );
        }
        */
    }
}
