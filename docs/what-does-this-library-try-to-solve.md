# What does this library try to solve?

## The problem

A common use of the Repository Pattern with an entity might look like this:

```php
<?php 

interface StudentRepository
{
    public function byId(string $id): ?Student;

    /**
    * @return Student[] 
    */
    public function byName(string $name): array;

}
```

Many of the cases where we load entities or value objects an I/O operation takes part on the process, like querying a 
database or requesting data to an external API. This is a perfect situation to use async I/O operations, which in PHP
can be accomplished using libraries (like Swoole, Amp, Guzzle, ReactPHP...) using promises.
Making use of the async clients provided with these libraries could speed up the whole process by allowing PHP to do other 
stuff while the I/O operation is processed. 

However, when we want to apply Promises to the Repository we exemplified, we run into some trouble:

```php
<?php 

interface StudentRepository
{
    public function byId(string $id): Promise;

    public function byName(string $name): Promise;

}
```

- If you are using Domain Driven Design, yusing Promises might be considered an implementation 
detail and not something to even consider in our Domain or Application layers. This solution doesn't follow this rule.  
 
- To make it worse, every async library has its own type of Promise implementation. This implies that different sources 
of data or using different libraries might result in using different Promise classes in our repositories.

- Besides, PHP does not have a native Promise abstraction, which would be useful on this case.

- Replacing all return types by `Promise` will make us lose strong typing for the interface contract.

- Enforcing promises at contract level will require then to enforce that every implementation of the interface should 
return a promise.

## Our solution

Our goal, as pointed out in the previous section, is to allow using Promises following the contract already defined for 
your application. 

The way this library achieves this goal is by wrapping the entity you want to load using a Promise into a new class that 
extends from your entity. Into this new class, we store the Promise, and replace all public methods of the class by 
custom implementations that will wait for the promise to end if executed, before accessing the real object loaded by 
the promise. Think of it like a lazy load, but around a Promise. 

Besides, this library provides different strategies to deal with the most common implementations of Promises along the 
different PHP libraries, and you can even implement one that fits your necessities. 

An example of implementation using this library can be seen in the 
[test src files](../src-test/Infrastructure/GuzzlePromiseStudentRepository.php).