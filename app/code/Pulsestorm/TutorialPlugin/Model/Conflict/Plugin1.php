<?php
namespace Pulsestorm\TutorialPlugin\Model\Conflict;
class Plugin1
{
    public function afterGetMessage($subject, $result)
    {
        echo "Calling " , __METHOD__ , "\n";    
        echo "Value of \$result: " . $result,"\n";
        return 'From Plugin 1';
    }
}
