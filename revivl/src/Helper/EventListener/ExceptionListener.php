<?php


namespace App\Helper\EventListener;


use App\Helper\Exception\ApiException;
use App\Helper\Exception\ResponseApp;
use Error;
use Psr\Log\LoggerInterface;
use Symfony\Component\ErrorHandler\Error\UndefinedMethodError;
use Symfony\Component\HttpClient\Exception\ClientException;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Event\ExceptionEvent;
use Symfony\Component\HttpKernel\KernelInterface;

class ExceptionListener
{
    public function __construct(private        readonly LoggerInterface $logger,
                                private        readonly KernelInterface $kernel,
                                private string $environment = 'prod',
    )
    {
        $this->environment = $this->kernel->getEnvironment();
    }

    public function onKernelException(ExceptionEvent $event): void
    {
        $exception = $event->getThrowable();
        $this->logger->error($exception->getMessage(), $exception->getTrace());

        $apiException = $exception;

        switch (true) {
            case $exception instanceof ClientException:
                $statusCode = method_exists($exception, 'getCode') ?
                    $exception->getCode() : null;

                $apiException = new ApiException(
                    statusCode: $statusCode,
                    message: $exception->getResponse()?->getContent(),
                    detail: $this->environment === 'dev' ? ResponseApp::getStatusName($statusCode) : null,
                );

                break;

            case $exception instanceof Error:
                $apiException = new ApiException(
                    statusCode: $exception->getCode() ?: ResponseApp::HTTP_INTERNAL_SERVER_ERROR,
                    message: $exception->getMessage(),
                    detail: $this->environment === 'dev' ? ResponseApp::getStatusName($exception->getCode()) : null,
                );

        }
        $event->setResponse(new JsonResponse($apiException->responseBody(), $apiException->getStatusCode() ?: ResponseApp::HTTP_INTERNAL_SERVER_ERROR));
    }
}