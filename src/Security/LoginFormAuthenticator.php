<?php

namespace App\Security;

use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Core\Exception\AuthenticationException;
use Symfony\Component\Security\Core\Exception\UsernameNotFoundException;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\UserProviderInterface;
use Symfony\Component\Security\Guard\AbstractGuardAuthenticator;

class LoginFormAuthenticator extends AbstractGuardAuthenticator
{
    protected $encoder;

    public function __construct(UserPasswordEncoderInterface $encoder)
    {
        $this->encoder = $encoder;
    }

    public function supports(Request $request)
    {
        return $request->attributes->get('_route') === 'security_login'
            && $request->isMethod('POST');
    }

    public function getCredentials(Request $request)
    {
        return $request->get('login'); //array avec 3 infos
    }

    public function getUser($credentials, UserProviderInterface $userProvider)
    {
        try 
        {
            return $userProvider->loadUserByUsername($credentials["email"]);
        }
        catch (UsernameNotFoundException $e)
        {
            throw new AuthenticationException("Cette adresse email n'est pas connu");
        }
        
    }

    public function checkCredentials($credentials, UserInterface $user)
    {
        // Vérifier sue le mot de passe fourni, coorespond bien au mot de passe de la base de donnée
        // $credentials['password'] => $user->getPassword()

        $isValid = $this->encoder->isPasswordValid($user, $credentials['password']);

        if (!$isValid)
        {
            throw new AuthenticationException("Les informations de connexion ne correspondent pas");
        }

        return true;      
    }

    public function onAuthenticationFailure(Request $request, AuthenticationException $exception)
    {
        $login = $request->request->get('login');
        $request->attributes->set(Security::LAST_USERNAME, $login['email']);
        $request->attributes->set(Security::AUTHENTICATION_ERROR, $exception);
    }

    public function onAuthenticationSuccess(Request $request, TokenInterface $token, string $providerKey)
    {
        return new RedirectResponse('/');
    }

    public function start(Request $request, AuthenticationException $authException = null)
    {
        // todo
    }

    public function supportsRememberMe()
    {
        // todo
    }
}
