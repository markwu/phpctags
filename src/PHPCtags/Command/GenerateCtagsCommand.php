<?php
namespace PHPCtags\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class GenerateCtagsCommand extends Command
{
    protected function configure()
    {
        $this->setName('phpctags')->setDescription('The phpctags command');

        $this->addArgument('files', InputArgument::REQUIRED | InputArgument::IS_ARRAY, 'Files/Folders to process');

        $this->addOption('append', 'a', InputOption::VALUE_OPTIONAL, 'Append the tags to an existing tag file. <info>[yes|no]</info>', 'no');
        $this->addOption('output', 'f|o', InputOption::VALUE_REQUIRED, 'Write tags to specified file. Value of <info>"-"</info> writes tags to stdout', 'tags');
        $this->addOption('cache', 'C', InputOption::VALUE_OPTIONAL, 'Use a cache file to store tags for faster updates.', 'tags.cache');
        $this->addOption('excmd', '', InputOption::VALUE_REQUIRED, 'Uses the specified type of EX command to locate tags. <info>[number|pattern|mix]</info>', 'mix');
        $this->addOption('exclude', '', InputOption::VALUE_REQUIRED | InputOption::VALUE_IS_ARRAY, 'Exclude files and directories matching pattern.');
        $this->addOption('recursive', 'R', InputOption::VALUE_OPTIONAL, 'Recurse into directories supplied on command line. <info>[yes|no]</info>', 'no');
        $this->addOption('fields', '', InputOption::VALUE_REQUIRED, 'Include selected extension fields <info>(flags: "[+|-]afmikKlnsStz").</info>', 'fks');
        $this->addOption('format', '', InputOption::VALUE_REQUIRED, 'Force output of specified tag file format.', 2);
        $this->addOption('sort', '', InputOption::VALUE_REQUIRED, 'Should tags be sorted (optionally ignoring case). <info>[yes|no|foldcase]</info>', 'yes');
        $this->addOption('memory', '', InputOption::VALUE_REQUIRED, 'Set how many memories phpctags could use. <info>[-1|bytes|KMG]</info>', ini_get('memory_limit'));
        $this->addOption('debug', '', InputOption::VALUE_NONE, "PHPCtags only, respect PHP's error level configuration.");
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        // $bar = $input->getOption('bar');
        // $output->writeln('<info>PHPCtags</info>' . ($bar ? ' (barred)': ' (basic)'));

        foreach ($input->getArgument('files') as $file) {
            $output->writeln('File: ' . $file);
        }
    }
}
