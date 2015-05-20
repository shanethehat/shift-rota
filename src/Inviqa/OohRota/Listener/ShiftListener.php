<?php

namespace Inviqa\OohRota\Listener;

use Inviqa\OohRota\Event\OohEvents;
use Inviqa\OohRota\Event\ShiftConfirmationEvent;
use Inviqa\OohRota\Event\ShiftRejectionEvent;
use Inviqa\OohRota\Notifier\Notifier;
use Inviqa\OohRota\User\UserRepository;

class ShiftListener implements EventSubscriber
{
    /**
     * @var Notifier
     */
    private $notifier;

    /**
     * @var UserRepository
     */
    private $adminRepository;

    public function __construct(Notifier $notifier, UserRepository $adminRepository)
    {
        $this->notifier = $notifier;
        $this->adminRepository = $adminRepository;
    }

    /**
     * Returns an array of event names this subscriber wants to listen to.
     *
     * The array keys are event names and the value can be:
     *
     *  * The method name to call (priority defaults to 0)
     *  * An array composed of the method name to call and the priority
     *  * An array of arrays composed of the method names to call and respective
     *    priorities, or 0 if unset
     *
     * For instance:
     *
     *  * array('eventName' => 'methodName')
     *  * array('eventName' => array('methodName', $priority))
     *  * array('eventName' => array(array('methodName1', $priority), array('methodName2'))
     *
     * @return array The event names to listen to
     *
     * @api
     */
    public static function getSubscribedEvents()
    {
        return [
            OohEvents::ENGINEER_CONFIRMS => 'onEngineerConfirmsShift',
            OohEvents::ENGINEER_REJECTS => 'onEngineerRejectsShift',
        ];
    }

    /**
     * @param ShiftConfirmationEvent $event
     */
    public function onEngineerConfirmsShift(ShiftConfirmationEvent $event)
    {
        if ($event->isEngineerConfirmed()) {
            return;
        }

        $message = sprintf(
            '%s has indicated that he/she is unavailable for the allocated shift %s',
            $event->getShiftEngineer()->getName(),
            $event->getShiftDate()->format('Y-m-d')
        );

        $this->notifyAdmins($message);
    }

    public function onEngineerRejectsShift(ShiftRejectionEvent $event)
    {
        $message = sprintf(
            '%s has rejected the allocated shift %s',
            $event->getEngineer()->getName(),
            $event->getShiftDate()->format('Y-m-d')
        );

        $this->notifyAdmins($message);
    }

    private function notifyAdmins($message)
    {
        $admins = $this->adminRepository->fetchAll();

        foreach ($admins as $admin) {
            $this->notifier->notify($admin, $message);
        }
    }
}
