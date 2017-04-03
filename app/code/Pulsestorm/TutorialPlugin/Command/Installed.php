<?php
namespace Pulsestorm\TutorialPlugin\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

use Pulsestorm\TutorialPlugin\Model\Example;

class Installed extends Command
{
    public function __construct(Example $example)
    {
        $this->example = $example;
        return parent::__construct();
    }
    
    protected function configure()
    {
        $this->setName("ps:tutorial-plugin-installed");
        $this->setDescription("Test that the command is installed.");
        parent::configure();
    }
    
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $output->writeln("You've installed Pulsestorm_TutorialPlugin");
    }
} 