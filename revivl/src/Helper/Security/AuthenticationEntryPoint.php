<?php


namespace App\Helper\Security;


use App\Helper\Exception\ApiException;
use App\Helper\Exception\ResponseApp;
use Symfony\Component\HttpFoundation\AcceptHeader;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\Security\Core\Exception\AuthenticationException;
use Symfony\Component\Security\Http\EntryPoint\AuthenticationEntryPointInterface;

class AuthenticationEntryPoint implements AuthenticationEntryPointInterface
{
    public function __construct(private readonly UrlGeneratorInterface $urlGenerator)
    {
    }

    public function start(Request $request, AuthenticationException $authException = null)
    {
        if (self::checkIsApiRequestByHeaders($request)) {
            throw new ApiException(
                Response::HTTP_UNAUTHORIZED,
                ResponseApp::getStatusName(Response::HTTP_UNAUTHORIZED),
                    'You have to login in order to access this page.',

                );
        }
        $request->getSession()->getFlashBag()->add('info', 'You have to login in order to access this page.');

        return new RedirectResponse($this->urlGenerator->generate('app_login'));
    }

    private static function checkIsApiRequestByHeaders(Request $request): bool
    {
        $acceptHeader = AcceptHeader::fromString($request->headers->get('Accept'));
        return $request->getContentType() === 'json' || $acceptHeader->has('application/json');
    }
}