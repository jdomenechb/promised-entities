# Promised Entities

Have you ever wondered how you can integrate asynchronous PHP features with code structures like Domain Driven Design? 

This library, among other uses, will allow you to use promises to instantiate objects asynchronously without having to 
compromise your code structure or use third-party classes in contract definition.

[What does this library try to solve?](docs/what-does-this-library-try-to-solve.md)

## Installation

Run in the root of your project:

```
composer require jdomenechb/promised-entities
```

## Usage 

```php

// ...

$promisedEntityFactory = PromisedEntityFactory::create(new GuzzleMethodBodyGenerator());
$promisedEntityFactory->build(YourEntity::class, $promise);
```

`$promise` is the Promise instance which resolution will return the loaded entity. It should match the given 
`MethodBodyGenerator` class which will know how to deal with it.

An example of implementation using this library can be seen in the 
[test src files](src-test/Infrastructure/GuzzlePromiseStudentRepository.php).