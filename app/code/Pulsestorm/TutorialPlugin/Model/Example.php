<?php
namespace Pulsestorm\TutorialPlugin\Model;
class Example
{
    public function getMessage($thing='World', $should_lc=false)
    {
        echo "Calling the real " . __METHOD__, "\n";
        $string = 'Hello ' . $thing . '!';
        if($should_lc)
        {
            $string = strToLower($string);
        }
        return $string;
    }
}
