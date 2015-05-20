<?php

namespace Inviqa\OohRota\Notifier;

use Inviqa\OohRota\User\User;

interface Notifier
{
    public function notify(User $user, $message);
}
