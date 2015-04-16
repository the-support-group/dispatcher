<?php

namespace Air\Routing\Dispatcher;

use Air\Routing\ResolvedRequest\ResolvedRequestInterface;
use Interop\Container\ContainerInterface;

class Dispatcher implements DispatcherInterface
{
    /**
     * @var ContainerInterface $container The DI container.
     */
    private $container;


    /**
     * @param ContainerInterface $container The DI container.
     */
    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
    }


    /**
     * Dispatch a route.
     *
     * @param ResolvedRequestInterface $resolvedRequest A resolved request.
     * @return string The response.
     */
    public function dispatch(ResolvedRequestInterface $resolvedRequest)
    {
        $route = $resolvedRequest->getRoute();
        $controller = $this->container->make($route->getController(), ['resolvedRequest' => $resolvedRequest]);

        // Call the before hook, if defined.
        if (method_exists($controller, 'before')) {
            $this->container->call(
                [$controller, 'before'],
                ['resolvedRequest' => $resolvedRequest] // The resolvedRequest parameter should always receive this.
            );
        }

        // Call the action.
        $response = $this->container->call(
            [$controller, 'action' . $route->getAction()],
            ['resolvedRequest' => $resolvedRequest] // The resolvedRequest parameter should always receive this.
        );

        // Call the after hook, if defined.
        if (method_exists($controller, 'after')) {
            $this->container->call(
                [$controller, 'after'],
                ['resolvedRequest' => $resolvedRequest] // The resolvedRequest parameter should always receive this.
            );
        }

        return $response;
    }
}
