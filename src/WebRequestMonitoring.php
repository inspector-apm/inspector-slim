<?php

namespace Inspector\Slim;


use Inspector\Inspector;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\ContainerInterface;
use Psr\Container\NotFoundExceptionInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Slim\Routing\RouteContext;

class WebRequestMonitoring implements MiddlewareInterface
{
    /**
     * The Inspector instance.
     *
     * @var Inspector
     */
    protected $inspector;

    /**
     * WebRequestMonitoring constructor.
     *
     * @param ContainerInterface $container
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     */
    public function __construct(ContainerInterface $container)
    {
        $this->inspector = $container->get('inspector');
    }

    /**
     * @inheritDoc
     */
    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        $response = $handler->handle($request);

        $routeContext = RouteContext::fromRequest($request);

        $transaction = $this->inspector->startTransaction(
            $request->getMethod() . ' ' . $routeContext->getRoute()->getPattern()
        );

        $transaction->addContext('Request Body', $request->getBody())
            ->addContext('Response', [
                'headers' => $response->getHeaders(),
            ]);

        $transaction->setResult($response->getStatusCode());

        return $response;
    }
}
