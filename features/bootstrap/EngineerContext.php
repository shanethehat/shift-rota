<?php

use Behat\Behat\Context\Context;
use Behat\Behat\Hook\Scope\AfterScenarioScope;
use Behat\Behat\Hook\Scope\BeforeScenarioScope;
use Behat\Behat\Tester\Exception\PendingException;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Tools\SchemaTool;
use Doctrine\ORM\Tools\Setup;
use Inviqa\OohRota\Listener\ShiftListener;
use Inviqa\OohRota\Notifier\Notifier;
use Inviqa\OohRota\Service\ShiftService;
use Inviqa\OohRota\Shift\DoctrineShiftRepository;
use Inviqa\OohRota\User\Administrator;
use Inviqa\OohRota\User\AdministratorRepository;
use Inviqa\OohRota\User\Engineer;
use Inviqa\OohRota\Schedule;
use Inviqa\OohRota\Shift;
use Inviqa\OohRota\TimePeriod\CalendarMonth;
use Inviqa\OohRota\User\User;
use Symfony\Component\EventDispatcher\EventDispatcher;

class EngineerContext implements Context, Notifier
{
    /**
     * @var Engineer
     */
    private $engineer;

    /**
     * @var Shift
     */
    private $shift;

    /**
     * @var EventDispatcher
     */
    private $dispatcher;

    /**
     * @var string[]
     */
    private $notifiedMessage = [];

    /**
     * @var User[]
     */
    private $notifiedUser = [];

    /**
     * @var User[]
     */
    private $administrators = [];

    /**
     * @var EntityManager
     */
    private $entityManager;

    /**
     * @var SchemaTool
     */
    private $schemaTool;

    /**
     * @var array
     */
    private $metadata;

    public function __construct()
    {
        $this->dispatcher = new EventDispatcher();

        $config = Setup::createAnnotationMetadataConfiguration(array(__DIR__."/../../src"), true);
        $conn = array(
            'driver' => 'pdo_sqlite',
            'path' => __DIR__ . '/db.sqlite',
        );

        $this->entityManager = EntityManager::create($conn, $config);

        $this->metadata = $this->entityManager->getMetadataFactory()->getAllMetadata();

        $this->schemaTool = new SchemaTool($this->entityManager);
    }

    /**
     * @BeforeScenario
     */
    public function beforeDatabase(BeforeScenarioScope $scope)
    {
        $this->schemaTool->createSchema($this->metadata);
    }

    /**
     * @AfterScenario
     */
    public function afterDatabase(AfterScenarioScope $scope)
    {
        $this->schemaTool->dropDatabase();
        unlink(__DIR__ . '/db.sqlite');
    }

    /**
     * @Given there is an engineer called :name
     */
    public function thereIsAnEngineerCalled($name)
    {
        $this->engineer = new Engineer($name);
        $this->entityManager->persist($this->engineer);
        $this->entityManager->flush();
    }

    /**
     * @Given there is a schedule for a future month
     */
    public function thereIsAScheduleForAFutureMonth()
    {
        throw new PendingException();
    }

    /**
     * @Given Bob has confirmed a shift he can no longer work
     */
    public function bobHasConfirmedAShiftHeCanNoLongerWork()
    {
        throw new PendingException();
    }

    /**
     * @Given Joe is available for the unwanted shift
     */
    public function joeIsAvailableForTheUnwantedShift()
    {
        throw new PendingException();
    }

    /**
     * @Given there are several months of schedules
     */
    public function thereAreSeveralMonthsOfSchedules()
    {
        throw new PendingException();
    }

    /**
     * @Given that Bob is allocated a shift
     */
    public function thatBobIsAllocatedAShift()
    {
        $this->shift = new Shift(new \DateTime());
        $this->shift->allocateEngineer($this->engineer);
    }

    /**
     * @When Bob confirms he is available
     */
    public function bobConfirmsHeIsAvailable()
    {
        $this->shift->confirmEngineer(true);
    }

    /**
     * @Then Bob will be confirmed for that shift
     */
    public function bobWillBeConfirmedForThatShift()
    {
        expect($this->shift->isEngineerConfirmed())->toBe(true);
    }

    /**
     * @Given that Bob is allocated a shift he cannot work
     */
    public function thatBobIsAllocatedAShiftHeCannotWork()
    {
        $shift = new Shift(\DateTime::createFromFormat('Y-m-d', '2015-05-19'));
        $shift->allocateEngineer($this->engineer);
        $this->entityManager->persist($shift);
        $this->entityManager->flush();

        $shiftListener = new ShiftListener($this, new AdministratorRepository($this->entityManager));
        $this->dispatcher->addSubscriber($shiftListener);
    }

    /**
     * @Given there is an administrator called :name
     */
    public function thereIsAnAdministratorCalled($name)
    {
        $administrator = new Administrator($name);
        $this->administrators[] = $administrator;
        $this->entityManager->persist($administrator);
        $this->entityManager->flush();
    }

    /**
     * @When Bob flags that he is unavailable
     */
    public function bobFlagsThatHeIsUnavailable()
    {
        $shiftService = new ShiftService($this->dispatcher);
        $shiftRepository = new DoctrineShiftRepository($this->entityManager);
        $shift = $shiftRepository->findShiftByDate(\DateTime::createFromFormat('Y-m-d', '2015-05-19'));
        $shiftService->engineerRejectShift($this->engineer, $shift);
    }

    /**
     * @Then the administrators will be informed that a shift is incorrectly allocated
     */
    public function theAdministratorsWillBeInformedThatAShiftIsIncorrectlyAllocated()
    {
        $message = 'Bob has rejected the allocated shift 2015-05-19';
        expect($this->notifiedUser)->toBe($this->administrators);
        expect($this->notifiedMessage)->toBe([$message, $message]);
    }

    /**
     * @Given Bob is part of the new month schedule
     */
    public function bobIsPartOfTheNewMonthSchedule()
    {
        $engineer = new Engineer('Bob');
        $month = new CalendarMonth();
        $this->schedule = new Schedule([$engineer], $month);
    }

    /**
     * @Given there is a shift Bob has not declined
     */
    public function thereIsAShiftBobHasNotDeclined()
    {
    }

    /**
     * @When Bob says that he cannot do a shift
     */
    public function bobSaysThatHeCannotDoAShift()
    {
        throw new PendingException();
    }

    /**
     * @Then Bob will be flagged as unavailable for that shift
     */
    public function bobWillBeFlaggedAsUnavailableForThatShift()
    {
        throw new PendingException();
    }

    /**
     * @Given that Bob has mistakenly said he cannot do a shift
     */
    public function thatBobHasMistakenlySaidHeCannotDoAShift()
    {
        throw new PendingException();
    }

    /**
     * @When Bob says that he is available for that shift
     */
    public function bobSaysThatHeIsAvailableForThatShift()
    {
        throw new PendingException();
    }

    /**
     * @Then Bob will be flagged as available for that shift
     */
    public function bobWillBeFlaggedAsAvailableForThatShift()
    {
        throw new PendingException();
    }

    /**
     * @Given that Bob has a primary phone number in his personal information
     */
    public function thatBobHasAPrimaryPhoneNumberInHisPersonalInformation()
    {
        throw new PendingException();
    }

    /**
     * @When Bob changes his phone number
     */
    public function bobChangesHisPhoneNumber()
    {
        throw new PendingException();
    }

    /**
     * @Then the new primary phone number is updated
     */
    public function theNewPrimaryPhoneNumberIsUpdated()
    {
        throw new PendingException();
    }

    /**
     * @Given that Bob cannot do his confirmed shift
     */
    public function thatBobCannotDoHisConfirmedShift()
    {
        throw new PendingException();
    }

    /**
     * @Given Bob requests a shift change
     */
    public function bobRequestsAShiftChange()
    {
        throw new PendingException();
    }

    /**
     * @Then available engineers are notified of an available shift
     */
    public function availableEngineersAreNotifiedOfAnAvailableShift()
    {
        throw new PendingException();
    }

    /**
     * @Given that Bob has requested a shift change
     */
    public function thatBobHasRequestedAShiftChange()
    {
        throw new PendingException();
    }

    /**
     * @Given Joe has received the chage request
     */
    public function joeHasReceivedTheChageRequest()
    {
        throw new PendingException();
    }

    /**
     * @Then Joe can accept the shift
     */
    public function joeCanAcceptTheShift()
    {
        throw new PendingException();
    }

    /**
     * @Then the shift will no longer be allocated to Bob
     */
    public function theShiftWillNoLongerBeAllocatedToBob()
    {
        throw new PendingException();
    }

    /**
     * @Then an administrator will be notified for the change
     */
    public function anAdministratorWillBeNotifiedForTheChange()
    {
        throw new PendingException();
    }

    /**
     * @Given Bob is able to access the system
     */
    public function bobIsAbleToAccessTheSystem()
    {
        throw new PendingException();
    }

    /**
     * @When Bob requests a list of months
     */
    public function bobRequestsAListOfMonths()
    {
        throw new PendingException();
    }

    /**
     * @Then he should see a list of months that have a schedule
     */
    public function heShouldSeeAListOfMonthsThatHaveASchedule()
    {
        throw new PendingException();
    }

    /**
     * @When Bob requests the shift schedule for a specific month
     */
    public function bobRequestsTheShiftScheduleForASpecificMonth()
    {
        throw new PendingException();
    }

    /**
     * @Then he should see the schedule for the specific month
     */
    public function heShouldSeeTheScheduleForTheSpecificMonth()
    {
        throw new PendingException();
    }

    /**
     * @When Bob requests the shift schedule for the current month
     */
    public function bobRequestsTheShiftScheduleForTheCurrentMonth()
    {
        throw new PendingException();
    }

    /**
     * @Then he should see the schedule for the current month
     */
    public function heShouldSeeTheScheduleForTheCurrentMonth()
    {
        throw new PendingException();
    }

    public function notify(User $user, $message)
    {
        $this->notifiedUser[] = $user;
        $this->notifiedMessage[] = $message;
    }
}
