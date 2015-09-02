<?php
namespace Pulsestorm\TutorialPlugin\Model\Conflict;
class Plugin2
{
    public function afterGetMessage($subject, $result)
    {
        echo "Calling " , __METHOD__ , "\n";   
        return 'From Plugin 2';
    }
}
