<?php


namespace App\Helper\Security;


use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\Security\Core\Exception\AuthenticationException;
use Symfony\Component\Security\Http\EntryPoint\AuthenticationEntryPointInterface;

class AuthenticationEntryPoint implements AuthenticationEntryPointInterface
{
    public function __construct(private UrlGeneratorInterface $urlGenerator,
                                private SessionInterface $session)
    {



        $this->urlGenerator = $urlGenerator;
        $this->session = $session;
    }
//
//    public function start(Request $request, AuthenticationException $authException = null): RedirectResponse
//    {
//        if (SecurityService::checkIsApiRequestByHeaders($request)) {
//            throw new ApiException(
//                'Для доступа к этому ресурсу вы должны быть авторизованы',
//                'Authorization required',
//                ResponseCode::HTTP_UNAUTHORIZED
//            );
//        }
//
//        $this->session->getFlashBag()->add('info', 'Для доступа к этому ресурсу вы должны быть авторизованы');
//        return new RedirectResponse($this->urlGenerator->generate('app_login'));
//    }
    public function start(Request $request, AuthenticationException $authException = null)
    {
        $request->getSession()->getFlashBag()->add('info', 'You have to login in order to access this page.');

        return new RedirectResponse($this->urlGenerator->generate('app_login'));
    }
}