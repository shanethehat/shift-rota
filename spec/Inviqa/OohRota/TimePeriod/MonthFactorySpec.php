<?php

namespace spec\Inviqa\OohRota\TimePeriod;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class MonthFactorySpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType('Inviqa\OohRota\TimePeriod\MonthFactory');
    }
}
