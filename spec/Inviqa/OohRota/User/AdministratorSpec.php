<?php

namespace spec\Inviqa\OohRota\User;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class AdministratorSpec extends ObjectBehavior
{
    function let()
    {
        $this->beConstructedWith('Bob');
    }

    function it_is_a_user()
    {
        $this->shouldImplement('Inviqa\OohRota\User\User');
    }

    function it_should_return_the_name()
    {
        $this->getName()->shouldReturn('Bob');
    }
}
