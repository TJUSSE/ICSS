<?php
/**
 * This file is part of openvj project.
 *
 * Copyright 2013-2015 openvj dev team.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace SSE\ICSSBundle\Security\User;

use Symfony\Component\Finder\Exception\AccessDeniedException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Authentication\SimplePreAuthenticatorInterface;
use Symfony\Component\Security\Core\Authentication\Token\PreAuthenticatedToken;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Exception\AuthenticationException;
use Symfony\Component\Security\Core\Exception\BadCredentialsException;
use Symfony\Component\Security\Core\User\UserProviderInterface;
use Symfony\Component\Security\Http\HttpUtils;

class HybridAuthenticator implements SimplePreAuthenticatorInterface
{
    protected $httpUtils;

    public function __construct(HttpUtils $httpUtils)
    {
        $this->httpUtils = $httpUtils;
    }

    public function authenticateToken(TokenInterface $token, UserProviderInterface $userProvider, $providerKey)
    {
        // 检查 user provider
        if (!$userProvider instanceof HybridUserProvider) {
            throw new \InvalidArgumentException(
                sprintf(
                    'The user provider must be an instance of HybridUserProvider (%s was given).',
                    get_class($userProvider)
                )
            );
        }

        $credential = $token->getCredentials();

        $user = $token->getUser();
        if ($user instanceof HybridUser) {
            return new PreAuthenticatedToken(
                $user,
                $credential,
                $providerKey,
                $user->getRoles()
            );
        }

        if ($credential['type'] === 'sso') {
            // 检查 SSO token
            $username = $userProvider->getUsernameForToken($credential['token']);
            if (!$username) {
                throw new AuthenticationException('统一身份登录会话无效，可能会话已过期。');
            }
        } else if ($token->getCredentials()['type'] === 'internal') {
            $username = $userProvider->getUsernameForInternalUser($credential['user'], $credential['pass']);
            if (!$username) {
                throw new AuthenticationException('用户名或密码错误。');
            }
        } else {
            throw new AccessDeniedException('不支持的登录认证类型。');
        }

        $user = $userProvider->loadUserByUsername($username);

        return new PreAuthenticatedToken(
            $user,
            $credential,
            $providerKey,
            $user->getRoles()
        );
    }

    public function supportsToken(TokenInterface $token, $providerKey)
    {
        return $token instanceof PreAuthenticatedToken && $token->getProviderKey() === $providerKey;
    }

    public function createToken(Request $request, $providerKey)
    {
        if ($this->httpUtils->checkRequestPath($request, '/login/check')) {
            // 内置用户登录
            if (!$request->request->has('username') || !$request->request->has('password')) {
                throw new BadCredentialsException('请输入用户名或密码');
            }
            return new PreAuthenticatedToken('anon.', [
                'type' => 'internal',
                'user' => $request->request->get('username'),
                'pass' => $request->request->get('password')
            ], $providerKey);
        } else if ($request->cookies->has('iPlanetDirectoryPro')) {
            // 同济大学统一身份登录
            return new PreAuthenticatedToken('anon.', [
                'type' => 'sso',
                'token' => $request->cookies->get('iPlanetDirectoryPro')
            ], $providerKey);
        } else {
            return;
        }
    }
}