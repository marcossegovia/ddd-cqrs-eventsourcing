<?php

namespace User\Domain\Model;

use Core\Domain\IsEventSourced;
use Core\Domain\Model\AggregateRoot;
use Core\Domain\Model\DomainEvent;
use Core\Infrastructure\EventBus\DomainEventRecorder;
use Store\Domain\Model\DrinkId;
use Store\Domain\Model\DrinkWasRated;

final class User implements IsEventSourced
{
    /** @var UserId */
    private $id;

    /** @var string */
    private $name;

    /** @var Email */
    private $email;

    /** @var array */
    private $rated_drinks;

    private function __construct(
        UserId $an_id
    )
    {
        $this->id = $an_id;
    }

    public static function create(
        UserId $an_id,
        string $a_name,
        Email $an_email
    )
    {
        $user = new self($an_id);
        $user->setName($a_name);
        $user->setEmail($an_email);
        $user->setRatedDrinks([]);
        DomainEventRecorder::instance()->recordMessage(new UserWasCreated($an_id, $a_name, $an_email));

        return $user;
    }

    private function setName(string $a_name)
    {
        $this->name = $a_name;
    }

    private function setEmail($an_email)
    {
        $this->email = $an_email;
    }

    private function setRatedDrinks(array $some_rated_drinks)
    {
        $this->rated_drinks = $some_rated_drinks;
    }

    /**
     * @return UserId
     */
    public function id()
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function name()
    {
        return $this->name;
    }

    /**
     * @return array
     */
    public function favoriteDrinks()
    {
        return $this->rated_drinks;
    }

    public function addDrink(DrinkId $a_drink_id)
    {
        $drink_was_rated = new DrinkWasRated($this->id, $a_drink_id);
        DomainEventRecorder::instance()->recordMessage($drink_was_rated);
        $this->rated_drinks[] = $a_drink_id;
    }

    public static function reconstituteFrom(
        AggregateRoot $an_aggregate_root,
        array $some_events
    )
    {
        $aggregate_id = $an_aggregate_root;
        $user         = new User($aggregate_id);

        foreach ($some_events as $event)
        {
            $user->apply($event);
        }

        return $user;
    }

    private function apply(DomainEvent $event)
    {
        $method = 'apply' . (new \ReflectionClass($event))->getShortName();
        $this->$method($event);
    }
    private function applyUserWasCreated(UserWasCreated $event)
    {
        $this->setName($event->name());
        $this->setEmail($event->email());
        $this->setRatedDrinks([]);
    }

    private function applyDrinkWasRated(DrinkWasRated $event)
    {
        $this->rated_drinks[] = $event->drinkId();
    }
}
