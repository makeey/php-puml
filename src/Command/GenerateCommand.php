<?php


namespace PhpUML\Command;

use PhpUML\Generator;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class GenerateCommand extends Command
{
    protected static $defaultName = 'generate';
    private Generator $generator;

    public function __construct(Generator $generator, string $name = null)
    {
        $this->generator = $generator;
        parent::__construct($name);
    }

    protected function configure(): void
    {
        $this->setDescription("Generate class diagram")
            ->setHelp("Generate class diagram for folder or single file");
        $this->addArgument("path", InputArgument::REQUIRED);
        $this->addArgument("output", InputArgument::REQUIRED);
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $output->writeln("Generating");
        $path = $input->getArgument('path');
        $outputPath = $input->getArgument('output');
        if (is_string($path) && is_string($outputPath)) {
            $this->generator->generate($path, $outputPath);
            $output->writeln("Finish. The result in {$outputPath}");
            return 0;
        } else {
            $output->write("Wrong format for the arguments");
            return 1;
        }
    }
}
