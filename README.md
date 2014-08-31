# Dispatcher
[![Build Status](https://scrutinizer-ci.com/g/air-php/dispatcher/badges/build.png?b=master)](https://scrutinizer-ci.com/g/air-php/dispatcher/build-status/master) [![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/air-php/dispatcher/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/air-php/dispatcher/?branch=master)

The dispatcher library includes classes for dispatching web application routes.

## Installation
Installation via [Composer](https://getcomposer.org/) is recommended.

    "require": {
        "air-php/dispatcher": "dev-master"
    }

## Dispatcher
The `dispatch()` method of the `Dispatcher` class takes a `ResolvedRequest` (compatible with Air's [ResolvedRequest interface](https://github.com/air-php/routing/blob/master/src/ResolvedRequest/ResolvedRequestInterface.php)) and dispatches it.

If present, the dispatcher will call a `before()` and `after()` method on the target controller, before and after it calls the controller's action. This provides two useful hooks for code execution in your application's controllers.