<?php

namespace Air\Routing\Dispatcher;

use Air\Routing\ResolvedRequest\ResolvedRequestInterface;

interface DispatcherInterface
{
    /**
     * Dispatch a route.
     *
     * @param ResolvedRequestInterface $resolvedRequest
     * @return string The response.
     */
    public function dispatch(ResolvedRequestInterface $resolvedRequest);
}
