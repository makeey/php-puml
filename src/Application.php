<?php


namespace PhpUML;

use PhpUML\Command\GenerateCommand;
use Symfony\Component\Console\Command\Command;

class Application implements IApplication
{
    private \Symfony\Component\Console\Application $application;

    public function __construct(Command ...$commands)
    {
        $this->application = new \Symfony\Component\Console\Application();
        $this->application->addCommands($commands);
    }

    public function run(): int
    {
        return $this->application->run();
    }
}
