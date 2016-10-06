<?php

declare(strict_types = 1);

use SimpleBus\Message\Bus\Middleware\FinishesHandlingMessageBeforeHandlingNext;
use SimpleBus\Message\Bus\Middleware\MessageBusSupportingMiddleware;
use SimpleBus\Message\Handler\DelegatesToMessageHandlerMiddleware;
use SimpleBus\Message\Handler\Map\LazyLoadingMessageHandlerMap;
use SimpleBus\Message\Handler\Resolver\NameBasedMessageHandlerResolver;
use SimpleBus\Message\Name\ClassBasedNameResolver;
use SimpleBus\Message\Subscriber\Collection\LazyLoadingMessageSubscriberCollection;
use SimpleBus\Message\Subscriber\NotifiesMessageSubscribersMiddleware;
use SimpleBus\Message\Subscriber\Resolver\NameBasedMessageSubscriberResolver;
use User\Domain\Model\User;
use User\Domain\Model\UserId;

require __DIR__ . '/vendor/autoload.php';

$container = new League\Container\Container;

/** EVENT STORE */
$container->share('Core\Domain\Infrastructure\EventStore', 'Core\Infrastructure\EventStore\InMemory\EventStore');

/** *** */
/** EVENT BUS */

$container->share(
    'EventBus',
    function () use (
        $container
    )
    {
        $eventSubscribersByEventName = [
            \User\Domain\Model\UserWasCreated::class   => [
                'user.application.subscriber.say_greetings_when_user_was_created',
                'read_model.rating_system.application.subscriber.user_projector'
            ],
            \Store\Domain\Model\DrinkWasCreated::class => [
                'read_model.rating_system.application.subscriber.drink_projector'
            ],
            \Store\Domain\Model\DrinkWasRated::class   => [
                'read_model.rating_system.application.subscriber.drink_projector'
            ],
        ];

        $event_bus = new MessageBusSupportingMiddleware();
        $event_bus->appendMiddleware(new FinishesHandlingMessageBeforeHandlingNext());
        $event_bus->appendMiddleware($container->get('Core\Domain\Infrastructure\EventStore'));

        $serviceLocator = function ($serviceId) use (
            $container
        )
        {
            $handler = $container->get($serviceId);

            return $handler;
        };

        $eventSubscriberCollection = new LazyLoadingMessageSubscriberCollection(
            $eventSubscribersByEventName, $serviceLocator
        );

        $eventNameResolver = new ClassBasedNameResolver();

        $eventSubscribersResolver = new NameBasedMessageSubscriberResolver(
            $eventNameResolver, $eventSubscriberCollection
        );

        $event_bus->appendMiddleware(
            new NotifiesMessageSubscribersMiddleware(
                $eventSubscribersResolver
            )
        );

        return $event_bus;
    }
);
/** *** */

/** COMMAND BUS */

$container->share(
    'CommandBus',
    function () use (
        $container
    )
    {
        $commandHandlersByCommandName = [
            \User\Application\Command\CreateNewUser::class       => 'user.application.service.create_new_user',
            \User\Application\Command\AddRatedDrinkToUser::class => 'user.application.service.add_rated_drink_to_user',
            \User\Application\Command\SayGreetings::class        => 'user.application.service.say_greetings',
            \Store\Application\Command\CreateNewDrink::class     => 'store.application.service.create_new_drink'
        ];

        $command_bus = new MessageBusSupportingMiddleware();
        $command_bus->appendMiddleware(new FinishesHandlingMessageBeforeHandlingNext());

        $serviceLocator = function ($serviceId) use (
            $container
        )
        {
            $handler = $container->get($serviceId);

            return $handler;
        };

        $commandHandlerMap = new LazyLoadingMessageHandlerMap(
            $commandHandlersByCommandName, $serviceLocator
        );

        $commandNameResolver = new ClassBasedNameResolver();

        $commandHandlerResolver = new NameBasedMessageHandlerResolver(
            $commandNameResolver, $commandHandlerMap
        );

        $command_bus->appendMiddleware(
            new DelegatesToMessageHandlerMiddleware(
                $commandHandlerResolver
            )
        );

        return $command_bus;
    }
);
/** *** */

/** READ MODEL DI */

//Infrastructure

$container->share(
    'ReadModel\RatingSystem\Domain\Repository\RatingRepository',
    'ReadModel\RatingSystem\Infrastructure\Repository\InMemory\Rating\RatingRepository'
);

//Subscribers
$container->share('read_model.rating_system.application.subscriber.drink_projector.original', 'ReadModel\RatingSystem\Application\Subscriber\DrinkProjector')->withArgument(
    'ReadModel\RatingSystem\Domain\Repository\RatingRepository'
);
$container->share('read_model.rating_system.application.subscriber.drink_projector', 'Core\Application\Subscriber\IsSubscribedToEvents')->withArgument(
    'read_model.rating_system.application.subscriber.drink_projector.original');

$container->share('read_model.rating_system.application.subscriber.user_projector.original', 'ReadModel\RatingSystem\Application\Subscriber\UserProjector')->withArgument(
    'ReadModel\RatingSystem\Domain\Repository\RatingRepository'
);
$container->share('read_model.rating_system.application.subscriber.user_projector', 'Core\Application\Subscriber\IsSubscribedToEvents')->withArgument(
    'read_model.rating_system.application.subscriber.drink_projector.original');

//Use cases
$container->add(
    'read_model.rating_system.application.service.get_user_drinks_rated',
    'ReadModel\RatingSystem\Application\Service\GetUserDrinksRated'
)->withArgument('ReadModel\RatingSystem\Domain\Repository\RatingRepository');
$container->add(
    'read_model.rating_system.application.service.get_users',
    'ReadModel\RatingSystem\Application\Service\GetUsers'
)->withArgument('ReadModel\RatingSystem\Domain\Repository\RatingRepository');
$container->add(
    'read_model.rating_system.application.service.get_drinks',
    'ReadModel\RatingSystem\Application\Service\GetDrinks'
)->withArgument('ReadModel\RatingSystem\Domain\Repository\RatingRepository');
/** *** */

/** WRITE MODEL DI */

//Infrastructure
$container->share(
    'User\Domain\Repository\UserRepository',
    'User\Infrastructure\Repository\InMemory\UserRepository'
);
$container->share(
    'Store\Domain\Repository\DrinkRepository',
    'Store\Infrastructure\Repository\InMemory\DrinkRepository'
);

//Subscribers
$container->add('user.application.subscriber.say_greetings_when_user_was_created.original', 'User\Application\Subscriber\SayGreetingsWhenUserWasCreated')->withArgument(
    'CommandBus'
);
$container->add('user.application.subscriber.say_greetings_when_user_was_created', 'Core\Application\Subscriber\IsSubscribedToEvents')->withArgument(
    'user.application.subscriber.say_greetings_when_user_was_created.original'
);

//Use cases with EventHandling
$container->add('user.application.service.create_new_user.original', 'User\Application\Service\CreateNewUser')->withArgument('User\Domain\Repository\UserRepository');
$container->add('user.application.service.create_new_user', 'Core\Application\Service\WithEventHandling')->withArgument(
    'user.application.service.create_new_user.original'
)->withArgument('EventBus');

$container->add('store.application.service.create_new_drink.original', 'Store\Application\Service\CreateNewDrink')->withArgument(
    'Store\Domain\Repository\DrinkRepository'
);
$container->add('store.application.service.create_new_drink', 'Core\Application\Service\WithEventHandling')->withArgument(
    'store.application.service.create_new_drink.original'
)->withArgument('EventBus');

$container->add(
    'user.application.service.add_rated_drink_to_user.original',
    'User\Application\Service\AddRatedDrinkToUser'
)->withArgument('User\Domain\Repository\UserRepository');
$container->add('user.application.service.add_rated_drink_to_user', 'Core\Application\Service\WithEventHandling')->withArgument(
    'user.application.service.add_rated_drink_to_user.original'
)->withArgument('EventBus');

//Use cases
$container->add('user.application.service.say_greetings.original', 'User\Application\Service\SayGreetings');
$container->add('user.application.service.say_greetings', 'Core\Application\Service\IsCommandHandled')->withArgument(
    'user.application.service.say_greetings.original'
)->withArgument('CommandBus');

/** *** */

$command_bus = $container->get('CommandBus');

$create_new_user_command = new \User\Application\Command\CreateNewUser('Marcos Segovia', 'marcos.segovia@uvinum.com');
$command_bus->handle($create_new_user_command);
