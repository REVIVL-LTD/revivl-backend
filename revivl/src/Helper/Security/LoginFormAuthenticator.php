<?php

namespace App\Helper\Security;

use App\Repository\UserRepository;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Exception\AuthenticationException;
use Symfony\Component\Security\Core\Exception\BadCredentialsException;
use Symfony\Component\Security\Core\Exception\CustomUserMessageAuthenticationException;
use Symfony\Component\Security\Core\Exception\TooManyLoginAttemptsAuthenticationException;
use Symfony\Component\Security\Core\Exception\UsernameNotFoundException;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\Security\Http\Authenticator\AbstractLoginFormAuthenticator;
use Symfony\Component\Security\Http\Authenticator\Passport\Badge\CsrfTokenBadge;
use Symfony\Component\Security\Http\Authenticator\Passport\Badge\UserBadge;
use Symfony\Component\Security\Http\Authenticator\Passport\Credentials\PasswordCredentials;
use Symfony\Component\Security\Http\Authenticator\Passport\Passport;
use Symfony\Component\Security\Http\Util\TargetPathTrait;

/**
 * Class LoginFormAuthenticator
 * @package App\Security
 */
class LoginFormAuthenticator extends AbstractLoginFormAuthenticator
{
    use TargetPathTrait;

    public const LOGIN_ROUTE = 'app_login';

    private UrlGeneratorInterface $urlGenerator;

    private UserRepository $userRepository;

    public function __construct(
        UrlGeneratorInterface $urlGenerator,
        UserRepository $userRepository
    )
    {
        $this->urlGenerator = $urlGenerator;
        $this->userRepository = $userRepository;
    }

    public function onAuthenticationSuccess(
        Request $request,
        TokenInterface $token,
        string $firewallName
    ): RedirectResponse
    {
        if ($targetPath = $this->getTargetPath($request->getSession(), $firewallName)) {
            if (!$this->checkIsApiUrl($targetPath)) {
                return new RedirectResponse($targetPath);
            }
        }
        $user = $token->getUser();
        if ($user) {
            return new RedirectResponse($this->urlGenerator->generate('app_lk'));
        }

        return new RedirectResponse($this->urlGenerator->generate('app_main'));
    }

    public function onAuthenticationFailure(Request $request, AuthenticationException $exception): Response
    {
        if ($request->hasSession()) {
            switch (true) {
                case $exception instanceof BadCredentialsException:
                case $exception instanceof UsernameNotFoundException:
                    $request->getSession()->set(
                        Security::AUTHENTICATION_ERROR,
                        new CustomUserMessageAuthenticationException(
                            'Email not found'
                        )
                    );
                    break;
                case $exception instanceof TooManyLoginAttemptsAuthenticationException:
                    $request->getSession()->set(
                        Security::AUTHENTICATION_ERROR,
                        new CustomUserMessageAuthenticationException(
                            'Too many failed logins, please try again later',
                        )
                    );
                    break;
                default:
                    $request->getSession()->set(Security::AUTHENTICATION_ERROR, $exception);
            }
        }

        $url = $this->getLoginUrl($request);

        return new RedirectResponse($url);
    }

    protected function getLoginUrl(Request $request): string
    {
        return $this->urlGenerator->generate(self::LOGIN_ROUTE);
    }

    protected function checkIsApiUrl(string $url): bool
    {
        $request = Request::create($url);
        return self::checkIsApiRequestByUrlContain($request);
    }

    private static function checkIsApiRequestByUrlContain(Request $request): bool
    {
        $urlRoute = $request->getPathInfo();
        return str_contains($urlRoute, '/api/');
    }

    public function authenticate(Request $request): Passport
    {
        $email = $request->request->get('email', '');

        $request->getSession()->set(Security::LAST_USERNAME, $email);

        return new Passport(
            new UserBadge($email, function ($userIdentifier) {
                return $this->userRepository->findOneBy(['email' => $userIdentifier]);
            }),
            new PasswordCredentials($request->request->get('password', '')),
            [
                new CsrfTokenBadge('authenticate', $request->get('_csrf_token')),
            ]
        );
    }
}
