<?php
namespace Pulsestorm\TutorialPlugin\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

use Pulsestorm\TutorialPlugin\Model\Example;

class Testbed extends Command
{
    public function __construct(Example $example)
    {
        $this->example = $example;
        return parent::__construct();
    }
    
    protected function configure()
    {
        $this->setName("ps:tutorial-plugin");
        $this->setDescription("A command the programmer was too lazy to enter a description for.");
        parent::configure();
    }

    protected function testPluginClassForClosureCall($class)
    {
        $reflection = new \ReflectionClass($class);
        $methods = $reflection->getMethods();
        foreach($methods as $method)
        {
            if(strpos($method->getName(), 'around') !== 0) { continue;}
            $parameters     = $method->getParameters();
            $chain_closure  = $parameters[1];
            $chain_closure_var_name = $chain_closure->getName();
    
            $lines = file($method->getFilename());
            array_unshift($lines,'');
            $method_lines = array_splice(
                $lines, 
                $method->getStartLine(), 
                $method->getEndLine() - $method->getStartLine()
            );
    
            $path = tempnam('/tmp', 'forstrip');            
            $method_text = implode('', $method_lines); 
            file_put_contents($path, '<' . '?' . 'php' . "\n" . $method_text );
            $method_text  = php_strip_whitespace($path);
            unlink($path);
            
            if(strpos($method_text, '$' . $chain_closure_var_name . '(') === false)
            {
                echo $class," : ";
                echo 'FAILED: ', ' could not find ' . '$' . $chain_closure_var_name . '()',"\n";
                echo '    ' . $reflection->getFilename() , "\n";
                echo '    ' . $method->getFilename(), "\n";
            }
            else
            {
                // echo $class," : ";            
                // echo 'PASSED',"\n";
            }
        }
    
    }
    
    protected function testAllPluginsForMissingClosure()
    {
        $files = glob('app/code/*/*/etc/di.xml');
        $classes = [];
        foreach($files as $file)
        {
            $xml = simplexml_load_file($file);
            $nodes = $xml->xpath('//plugin');
            foreach($nodes as $node)
            {
                $classes[] = (string)$node['type'];
            }
        }
        
        // $classes = ['Pulsestorm\TutorialPlugin\Model\Example\Plugin'];
        foreach($classes as $class)
        {
            $this->testPluginClassForClosureCall($class);
        }    
    }
    
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $output->writeln(
            "\nWe're going to call the `getMessage` method on the class " . "\n\n" .
            '    ' . get_class($this->example) . "\n"
        );
        
        $result = $this->example->getMessage("Hola", true);
        $output->writeln('Result: ' . $result);
    }
} 