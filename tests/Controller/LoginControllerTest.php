<?php

namespace App\Tests\Security;

use App\Security\AppAuthenticator;
use PHPUnit\Framework\TestCase;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\HttpFoundation\InputBag;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Http\Authenticator\Passport\Badge\CsrfTokenBadge;
use Symfony\Component\Security\Http\Authenticator\Passport\Badge\RememberMeBadge;
use Symfony\Component\Security\Http\Authenticator\Passport\Badge\UserBadge;
use Symfony\Component\Security\Http\Authenticator\Passport\Credentials\PasswordCredentials;
use Symfony\Component\Security\Http\Authenticator\Passport\Passport;
use Symfony\Component\Security\Http\Authenticator\Passport\PassportInterface;
use Symfony\Component\Security\Http\SecurityRequestAttributes;

class LoginControllerTest extends TestCase
{
    private $urlGenerator;
    private $authenticator;

    protected function setUp(): void
    {
        $this->urlGenerator = $this->createMock(UrlGeneratorInterface::class);
        $this->authenticator = new AppAuthenticator($this->urlGenerator);
    }

    public function testAuthenticate(): void
    {
        $request = $this->createMock(Request::class);
        $session = $this->createMock(SessionInterface::class);
        
        $payload = new InputBag([
            'username' => 'testuser',
            'password' => 'testpassword',
            '_csrf_token' => 'testtoken'
        ]);

        $request->method('getPayload')->willReturn($payload);
        $request->method('getSession')->willReturn($session);
        
        $session->expects($this->once())
            ->method('set')
            ->with(SecurityRequestAttributes::LAST_USERNAME, 'testuser');

        $passport = $this->authenticator->authenticate($request);

        $this->assertInstanceOf(Passport::class, $passport);
        $this->assertEquals('testuser', $passport->getBadge(UserBadge::class)->getUserIdentifier());
        $this->assertEquals('testpassword', $passport->getBadge(PasswordCredentials::class)->getPassword());
        $this->assertInstanceOf(CsrfTokenBadge::class, $passport->getBadge(CsrfTokenBadge::class));
        $this->assertInstanceOf(RememberMeBadge::class, $passport->getBadge(RememberMeBadge::class));
    }

    public function testOnAuthenticationSuccessWithTargetPath(): void
    {
        $request = $this->createMock(Request::class);
        $session = $this->createMock(SessionInterface::class);
        $token = $this->createMock(TokenInterface::class);

        $request->method('getSession')->willReturn($session);

        $session->method('get')->willReturn('/target-path');

        $response = $this->authenticator->onAuthenticationSuccess($request, $token, 'main');

        $this->assertInstanceOf(RedirectResponse::class, $response);
        $this->assertEquals('/target-path', $response->getTargetUrl());
    }

    public function testOnAuthenticationSuccessWithoutTargetPath(): void
    {
        $request = $this->createMock(Request::class);
        $session = $this->createMock(SessionInterface::class);
        $token = $this->createMock(TokenInterface::class);

        $request->method('getSession')->willReturn($session);

        $this->urlGenerator->method('generate')
            ->with('app_home')
            ->willReturn('/home');

        $response = $this->authenticator->onAuthenticationSuccess($request, $token, 'main');

        $this->assertInstanceOf(RedirectResponse::class, $response);
        $this->assertEquals('/home', $response->getTargetUrl());
    }

    public function testGetLoginUrl(): void
    {
        $request = $this->createMock(Request::class);

        $this->urlGenerator->method('generate')
            ->with(AppAuthenticator::LOGIN_ROUTE)
            ->willReturn('/login');

        $reflection = new \ReflectionClass(AppAuthenticator::class);
        $method = $reflection->getMethod('getLoginUrl');
        $method->setAccessible(true);

        $loginUrl = $method->invoke($this->authenticator, $request);

        $this->assertEquals('/login', $loginUrl);
    }
}
