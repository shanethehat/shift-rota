<?php

namespace spec\Inviqa\OohRota\User;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class EngineerSpec extends ObjectBehavior
{
    function let()
    {
        $this->beConstructedWith('bob');
    }

    function it_should_be_a_user()
    {
        $this->shouldImplement('Inviqa\OohRota\User\User');
    }

    function it_should_return_the_user_name()
    {
        $this->getName()->shouldReturn('bob');
    }
}
