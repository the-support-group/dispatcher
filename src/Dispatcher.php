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
        $request = $resolvedRequest->getRequest();
        $controller = $this->container->get($route->getController());

        // Call the before hook, if defined.
        if (method_exists($controller, 'before')) {
            $controller->before();
        }

        // Call the action.
        $response = call_user_func_array(
            [$controller, 'action' . $route->getAction()],
            [
                $resolvedRequest->getUriParameters(),
                [
                    'params' => $request->getQueryParameters()
                ]
            ]
        );

        // Call the after hook, if defined.
        if (method_exists($controller, 'after')) {
            $controller->after();
        }

        return $response;
    }
}
