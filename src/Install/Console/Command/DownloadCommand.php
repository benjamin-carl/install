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

namespace Install\Console\Command;

use Install\Console\Helper\ProgressbarFactory;
use Install\File\Downloader;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Exception\InvalidArgumentException;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Rng\Generator;

/**
 * Class DownloadCommand
 *
 * @package Install\Console\Command
 * @author  Benjamin Carl <opensource@clickalicious.de>
 */
class DownloadCommand extends Command
{
    /**
     * Configuration of download command.
     *
     * @return void
     * @throws InvalidArgumentException
     */
    protected function configure()
    {
        $randomizer = new Generator(Generator::MODE_PHP_MERSENNE_TWISTER, time());

        $this->setName('file:download')
             ->setDescription('This command downloads a file to local filesystem.')
             ->setDefinition([
                 new InputArgument(
                     'file-uri', InputArgument::REQUIRED, 'The file URI to download from.'
                 ),
                 new InputArgument(
                     'destination-filename',
                     InputArgument::OPTIONAL,
                     'Name of the downloaded file to write to local filesystem.'
                 ),
                 new InputArgument(
                     'destination-directory',
                     InputArgument::OPTIONAL,
                     'Name of the directory to write the downloaded file to.',
                     getcwd()
                 ),
                 new InputArgument(
                     'temporary-filename',
                     InputArgument::OPTIONAL,
                     'Name of the temporary file to write downloaded bytes in.',
                     sha1($randomizer->getRandomBytes(16))
                 ),
                 new InputArgument(
                     'temporary-directory',
                     InputArgument::OPTIONAL,
                     'Name of the temporary directory to write temporary file to.',
                     sys_get_temp_dir()
                 ),
                 new InputOption(
                     'ignore-ssl-certificate',
                     'i',
                     InputOption::VALUE_NONE,
                     'Flag to ignore invalid SSL certificate.'
                 ),
                 new InputOption(
                    'no-progress',
                     'np',
                     InputOption::VALUE_NONE,
                     'Flag to hide progress when downloading file.'
                 ),
             ])
             ->setHelp('The <info>download</info> command downloads a file from a given URI to the local filesystem.');
    }

    /**
     * Executes the command.
     *
     * @param InputInterface  $input  Input
     * @param OutputInterface $output Output
     *
     * @return int|null|void
     * @throws InvalidArgumentException
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        // Arguments
        $fileUri              = $input->getArgument('file-uri');
        $destinationFilename  = $input->getArgument('destination-filename');
        $destinationDirectory = $input->getArgument('destination-directory');
        $temporaryFilename    = $input->getArgument('temporary-filename');
        $temporaryDirectory   = $input->getArgument('temporary-directory');

        // Options
        $ignoreSslCertificate = $input->getOption('ignore-ssl-certificate');
        $noProgress           = $input->getOption('no-progress');

        // Check for progressbar
        $progressbarCallback = null;

        if (false === $noProgress) {
            $progressbarFactory  = new ProgressbarFactory();
            $progressbarCallback = $progressbarFactory->create($output);
        }

        $downloader = new Downloader($ignoreSslCertificate);

        // Start download
        if (true !== $result = $downloader->download(
                $fileUri,
                $destinationDirectory,
                $destinationFilename,
                $temporaryDirectory,
                $temporaryFilename,
                $progressbarCallback
            )
        ) {
            $output->writeln(
                sprintf("\n<error>Error \"%s\" while downloading file \"%s\".</error>", $result, $fileUri)
            );

        } else {
            $output->writeln(
                sprintf(
                    "\n<info>File \"%s\" downloaded successful to.</info>",
                    $fileUri
                )
            );
        }
    }
}
