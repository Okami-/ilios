<?php
namespace Ilios\CoreBundle\Tests\Classes;

use Symfony\Bundle\FrameworkBundle\Tests\TestCase;
use Symfony\Component\HttpFoundation\JsonResponse;
use Mockery as m;

use Ilios\AuthenticationBundle\Service\ShibbolethAuthentication;

class ShibbolethAuthenticationTest extends TestCase
{
    public function tearDown()
    {
        m::close();
    }

    public function testConstructor()
    {
        $authManager = m::mock('Ilios\CoreBundle\Entity\Manager\AuthenticationManagerInterface');
        $tokenStorage = m::mock('Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface');
        $jwtManager = m::mock('Ilios\AuthenticationBundle\Service\JsonWebTokenManager');
        $obj = new ShibbolethAuthentication(
            $authManager,
            $tokenStorage,
            $jwtManager
        );
        $this->assertTrue($obj instanceof ShibbolethAuthentication);
    }
    
    public function testNotAuthenticated()
    {
        $authManager = m::mock('Ilios\CoreBundle\Entity\Manager\AuthenticationManagerInterface');
        $tokenStorage = m::mock('Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface');
        $jwtManager = m::mock('Ilios\AuthenticationBundle\Service\JsonWebTokenManager');
        $obj = new ShibbolethAuthentication(
            $authManager,
            $tokenStorage,
            $jwtManager
        );
        
        $serverBag = m::mock('Symfony\Component\HttpFoundation\ServerBag')
            ->shouldReceive('get')->with('Shib-Application-ID')->andReturn(false)
            ->mock();
        $request = m::mock('Symfony\Component\HttpFoundation\Request');
        $request->server = $serverBag;
        
        $result = $obj->login($request);
        
        $this->assertTrue($result instanceof JsonResponse);
        $content = $result->getContent();
        $data = json_decode($content);
        $this->assertSame($data->status, 'redirect');
    }
    
    public function testNoEppn()
    {
        $authManager = m::mock('Ilios\CoreBundle\Entity\Manager\AuthenticationManagerInterface');
        $tokenStorage = m::mock('Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface');
        $jwtManager = m::mock('Ilios\AuthenticationBundle\Service\JsonWebTokenManager');
        $obj = new ShibbolethAuthentication(
            $authManager,
            $tokenStorage,
            $jwtManager
        );
        
        $serverBag = m::mock('Symfony\Component\HttpFoundation\ServerBag')
            ->shouldReceive('get')->with('Shib-Application-ID')->andReturn(true)
            ->shouldReceive('get')->with('eppn')->andReturn(false)
            ->mock();
        $request = m::mock('Symfony\Component\HttpFoundation\Request');
        $request->server = $serverBag;
        $this->setExpectedException('Exception');
        $obj->login($request);
    }
    
    public function testNoUserWithEppn()
    {
        $authManager = m::mock('Ilios\CoreBundle\Entity\Manager\AuthenticationManagerInterface');
        $tokenStorage = m::mock('Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface');
        $jwtManager = m::mock('Ilios\AuthenticationBundle\Service\JsonWebTokenManager');
        $obj = new ShibbolethAuthentication(
            $authManager,
            $tokenStorage,
            $jwtManager
        );
        
        $serverBag = m::mock('Symfony\Component\HttpFoundation\ServerBag')
            ->shouldReceive('get')->with('Shib-Application-ID')->andReturn(true)
            ->shouldReceive('get')->with('eppn')->andReturn('userid1')
            ->mock();
        $request = m::mock('Symfony\Component\HttpFoundation\Request');
        $request->server = $serverBag;
        $authManager->shouldReceive('findAuthenticationBy')
            ->with(array('eppn' => 'userid1'))->andReturn(null);

        $result = $obj->login($request);
        
        $this->assertTrue($result instanceof JsonResponse);
        $content = $result->getContent();
        $data = json_decode($content);
        $this->assertSame($data->status, 'noAccountExists');
        $this->assertSame($data->eppn, 'userid1');
    }
    
    public function testSuccess()
    {
        $authManager = m::mock('Ilios\CoreBundle\Entity\Manager\AuthenticationManagerInterface');
        $tokenStorage = m::mock('Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface');
        $jwtManager = m::mock('Ilios\AuthenticationBundle\Service\JsonWebTokenManager');
        $obj = new ShibbolethAuthentication(
            $authManager,
            $tokenStorage,
            $jwtManager
        );
        
        $serverBag = m::mock('Symfony\Component\HttpFoundation\ServerBag')
            ->shouldReceive('get')->with('Shib-Application-ID')->andReturn(true)
            ->shouldReceive('get')->with('eppn')->andReturn('userid1')
            ->mock();
        $request = m::mock('Symfony\Component\HttpFoundation\Request');
        $request->server = $serverBag;
        
        $user = m::mock('Ilios\CoreBundle\Entity\UserInterface');
        $authenticationEntity = m::mock('Ilios\CoreBundle\Entity\AuthenticationInterface')
            ->shouldReceive('getUser')->andReturn($user)->mock();
        $authManager->shouldReceive('findAuthenticationBy')
            ->with(array('eppn' => 'userid1'))->andReturn($authenticationEntity);
        $newToken = m::mock('Ilios\AuthenticationBundle\Jwt\Token')
            ->shouldReceive('getJwt')->andReturn('jwt123Test')->mock();
        $tokenStorage->shouldReceive('setToken')->with($newToken);
        $jwtManager->shouldReceive('buildToken')->with($user)->andReturn($newToken);
        
        
        $result = $obj->login($request);
        
        $this->assertTrue($result instanceof JsonResponse);
        $content = $result->getContent();
        $data = json_decode($content);
        $this->assertSame($data->status, 'success');
        $this->assertSame($data->jwt, 'jwt123Test');
    }
}