<?php
namespace PHPCtags\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Output\OutputInterface;

class GenerateCtagsCommand extends Command
{
    protected function configure()
    {
        $this->setName('phpctags')->setDescription('The phpctags command');

        $this->addArgument('files', InputArgument::REQUIRED | InputArgument::IS_ARRAY, 'Files/Folders to process');

        $this->addOption('append', 'a', InputOption::VALUE_NONE, 'Append the tags to an existing tag file.');
        $this->addOption('output', 'f|o', InputOption::VALUE_REQUIRED, 'Write tags to specified file. Value of <info>"-"</info> writes tags to stdout', 'tags');
        $this->addOption('cache', 'C', InputOption::VALUE_REQUIRED, 'Use a cache file to store tags for faster updates.');
        $this->addOption('excmd', '', InputOption::VALUE_REQUIRED, 'Uses the specified type of EX command to locate tags. <info>[--excmd=(number|pattern|mix)]</info>', 'mix');
        $this->addOption('exclude', '', InputOption::VALUE_REQUIRED | InputOption::VALUE_IS_ARRAY, 'Exclude files and directories matching pattern.');
        $this->addOption('recursive', 'R', InputOption::VALUE_NONE, 'Recurse into directories supplied on command line.');
        $this->addOption('fields', '', InputOption::VALUE_REQUIRED, 'Include selected extension fields <info>[--fields=([+|-]afmikKlnsStz)].</info>', 'fks');
        $this->addOption('format', '', InputOption::VALUE_REQUIRED, 'Force output of specified tag file format.', 2);
        $this->addOption('sort', '', InputOption::VALUE_REQUIRED, 'Should tags be sorted (optionally ignoring case). <info>[--sort=(yes|no|foldcase)]</info>', 'yes');
        $this->addOption('memory', '', InputOption::VALUE_REQUIRED, 'Set how many memories phpctags could use. <info>[--memory=(-1|<bytes>[K|M|G])]</info>', ini_get('memory_limit'));
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $append = $input->getOption('append');
        $output->writeln('<info>--append</info>: ' . $append);

        foreach ($input->getArgument('files') as $file) {
            $output->writeln('File: ' . $file);
        }
    }
}
