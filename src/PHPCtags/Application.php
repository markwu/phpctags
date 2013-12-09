<?php
namespace PHPCtags;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class Application extends \Symfony\Component\Console\Application
{
    private $commandName;

    public function __construct(Command $command, $version = 'UNKNOWN')
    {
        parent::__construct($command->getName(), $version);

        $this->add($command);
        $this->commandName = $command->getName();

        // Override the Application's definition so that it does not
        // require a command name as first argument.
        $this->getDefinition()->setArguments();
    }

    protected function getCommandName(InputInterface $input)
    {
        return $this->commandName;
    }

    public function add(Command $command)
    {
        // Fail if we already set up the single accessible command.
        if ($this->commandName) {
            throw new \LogicException("You should not add more than one command to a PHPCtags\Application instance.");
        }

        return parent::add($command);
    }

    public function renderException($e, $output)
    {
        $formatter = $this->getHelperSet()->get('formatter');
        $output->writeln($this->getLongVersion());
        $output->writeln("");

        do {
            $exception = get_class($e);
            $messages = $e->getMessage();
            $messages = str_replace("\n", '', $messages);
            $messages = str_replace("\r", '', $messages);

            $formattedLine = $formatter->formatSection($exception, $messages, 'error');
            $output->writeln($formattedLine);
            $output->writeln("");

            if (OutputInterface::VERBOSITY_VERBOSE <= $output->getVerbosity()) {
                $output->writeln('<comment>Exception trace:</comment>');

                // exception related properties
                $trace = $e->getTrace();
                array_unshift($trace, array(
                    'function' => '',
                    'file' => $e->getFile() != null ? $e->getFile() : 'n/a',
                    'line' => $e->getLine() != null ? $e->getLine() : 'n/a',
                    'args' => array(),
                ));

                for ($i = 0, $count = count($trace); $i < $count; $i++) {
                    $class = isset($trace[$i]['class']) ? $trace[$i]['class'] : '';
                    $type = isset($trace[$i]['type']) ? $trace[$i]['type'] : '';
                    $function = $trace[$i]['function'];
                    $file = isset($trace[$i]['file']) ? $trace[$i]['file'] : 'n/a';
                    $line = isset($trace[$i]['line']) ? $trace[$i]['line'] : 'n/a';

                    $output->writeln(sprintf(' %s%s%s() at <info>%s:%s</info>', $class, $type, $function, $file, $line));
                }

                $output->writeln("");
            }
        } while ($e = $e->getPrevious());

        $formattedLine = $formatter->formatSection('Tip', 'Using "--help" to get more information.', 'comment');
        $output->writeln($formattedLine);
        $output->writeln("");
    }
}
