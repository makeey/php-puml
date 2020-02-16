<?php


namespace PhpUML\Command;


use PhpUML\Generator;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class GenerateCommand extends Command
{
    /** @var Generator */
    private $generator;

    public function __construct(Generator $generator, string $name = null)
    {
        $this->generator = $generator;
        parent::__construct($name);
    }

    protected static $defaultName = 'app:generate-uml';

    protected function configure()
    {
        $this->setDescription("Generate UML")
            ->setHelp("Generate UML diagram for folder or single file");
        $this->addArgument("path", InputArgument::REQUIRED);
        $this->addArgument("output", InputArgument::REQUIRED);
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $output->writeln("Generating");
        $this->generator->generate($input->getArgument('path'), $input->getArgument('output'));
        $output->writeln("Done the uml in {$input->getArgument('output')}");
        return 0;
    }
}