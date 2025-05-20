<?php

namespace App\Security;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Exception\AuthenticationException;
use Symfony\Component\Security\Http\Authenticator\AbstractAuthenticator;
use Symfony\Component\Security\Http\Authenticator\Passport\Passport;
use Symfony\Component\Security\Http\Authenticator\Passport\Badge\CsrfTokenBadge;
use Symfony\Component\Security\Http\Authenticator\Passport\Badge\UserBadge;
use Symfony\Component\Security\Http\Authenticator\Passport\Credentials\PasswordCredentials;

class LoginFormAuthenticator extends AbstractAuthenticator
{
    private UrlGeneratorInterface $urlGenerator;

    public function __construct(UrlGeneratorInterface $urlGenerator)
    {
        $this->urlGenerator = $urlGenerator;
    }

    public function supports(Request $request): ?bool
    {
        // We support login form submission only on the route 'app_login' with POST method
        return $request->attributes->get('_route') === 'app_login'
            && $request->isMethod('POST');
    }

    public function authenticate(Request $request): Passport
    {
        $username = $request->request->get('_username', '');
        $password = $request->request->get('_password', '');

        return new Passport(
            new UserBadge($username),
            new PasswordCredentials($password),
            [
                new CsrfTokenBadge('authenticate', $request->request->get('_csrf_token')),
            ]
        );
    }

    public function onAuthenticationSuccess(Request $request, TokenInterface $token, string $firewallName): ?RedirectResponse
    {
        // Redirect to dashboard or intended page after successful login
        return new RedirectResponse($this->urlGenerator->generate('app_dashboard_redirect'));
    }

    public function onAuthenticationFailure(Request $request, AuthenticationException $exception): ?RedirectResponse
    {
        // On failure, redirect back to login page with error message handled by controller
        return new RedirectResponse($this->urlGenerator->generate('app_login'));
    }
}
