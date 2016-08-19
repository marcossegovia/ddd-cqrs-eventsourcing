<?php

namespace Core\Infrastructure\EventBus;

use Core\Domain\Infrastructure\EventBus as EventBusInterface;
use League\Container\Container;
use SimpleBus\Message\Bus\Middleware\FinishesHandlingMessageBeforeHandlingNext;
use SimpleBus\Message\Bus\Middleware\MessageBusSupportingMiddleware;
use SimpleBus\Message\Name\ClassBasedNameResolver;
use SimpleBus\Message\Subscriber\Collection\LazyLoadingMessageSubscriberCollection;
use SimpleBus\Message\Subscriber\NotifiesMessageSubscribersMiddleware;
use SimpleBus\Message\Subscriber\Resolver\NameBasedMessageSubscriberResolver;

final class EventBus implements EventBusInterface
{
    /** @var MessageBusSupportingMiddleware */
    private $event_bus;

    /** @var Container */
    private $container;

    public function __construct(
        MessageBusSupportingMiddleware $a_simple_bus_event_bus,
        Container $a_container
    )
    {
        $this->event_bus = $a_simple_bus_event_bus;
        $this->container = $a_container;

        $eventSubscribersByEventName = $this->indexAllEventSubscribersByEvent();

        $this->event_bus = new MessageBusSupportingMiddleware();
        $this->event_bus->appendMiddleware(new FinishesHandlingMessageBeforeHandlingNext());

        $serviceLocator = function($serviceId)
        {
            $handler = $this->container->get($serviceId);

            return $handler;
        };

        $eventSubscriberCollection = new LazyLoadingMessageSubscriberCollection(
            $eventSubscribersByEventName,
            $serviceLocator
        );

        $eventNameResolver = new ClassBasedNameResolver();

        $eventSubscribersResolver = new NameBasedMessageSubscriberResolver(
            $eventNameResolver,
            $eventSubscriberCollection
        );

        $this->event_bus->appendMiddleware(
            new NotifiesMessageSubscribersMiddleware(
                $eventSubscribersResolver
            )
        );
    }

    private function indexAllEventSubscribersByEvent()
    {
        $eventSubscribersByEventName = [
            \User\Domain\Model\UserWasCreated::class => [
                'read_model.rating_system.application.subscriber.user_was_created_handler'
            ],
            \Store\Domain\Model\DrinkWasCreated::class => [
                'read_model.rating_system.application.subscriber.drink_was_created_handler'
            ],
            \Store\Domain\Model\DrinkWasRated::class => [
                'read_model.rating_system.application.subscriber.drink_was_rated_handler'
            ],
        ];

        return $eventSubscribersByEventName;
    }
}
