# DDD, Hexagonal, CQRS and Event-Sourcing

This repository wants to be a one more example of consolidating two Bounded Context (strategic DDD) with a CQRS architecture approach for splitting Write model from Read model. Also applying Event-Sourcing to be able to store the events, project their data into the ReadModel and replay Aggregates anywhere in time.

## Write Model

Execute Command -> Application Service (Use case) -> Aggregates (DDD Models) -> Persist in Write Model DB -> NOT returns.

DDD Models throw Events and Subscribers updates the Query Model DB (Read Model)
Events are needed when performing changes in the Write model in order to update the Read Model. Also associations (Other related aggregates) due to the command performed are committed based in Eventual Consistency.


## Read Model

Execute Query -> Read from Read Model DB -> Returns Response as plain data or maybe a DTO.

DB in Read Model is completely optimised to perform reads from clients. Multiple Aggregates can be merged in the same table to provide speed.
It is a good idea to provide specific views for specific roles within the application.


## Projections

Special subscribers register to receive all Domain Events published by the Write Model.
The Subscriber uses each Domain Event to update the Read Model in order to reflect the most recent changes from the Write Model.
So it implies that **each Event must be rich enough to supply all the data necessary** to produce the correct state in the Read Model. 
--- Implementing Domain Driven Design. Vaughn Vernon.


## Event Store

The Event Store is appended into the Event Bus so it is subscribed to all the events that are ocurring within the application.
It justs records every domain event occurred to be able to retrieve the array of events associated to an `AggregatedRoot` id.
