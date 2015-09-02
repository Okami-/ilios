<?php
namespace Ilios\AuthenticationBundle\Tests\DependencyInjection;

use Matthias\SymfonyConfigTest\PhpUnit\ConfigurationTestCaseTrait;
use Ilios\AuthenticationBundle\DependencyInjection\Configuration;

class ConfigurationTest extends \PHPUnit_Framework_TestCase
{
    use ConfigurationTestCaseTrait;
    protected function getConfiguration()
    {
        return new Configuration();
    }
    
    public function testRequiredConfigValues()
    {
        $this->assertConfigurationIsInvalid(
            array(
                array() // no values at all
            ),
            'type'
        );
    }
    
    public function testInvalidAuthType()
    {
        $this->assertConfigurationIsInvalid(
            array(
                array('type' => 'nothing') // no values at all
            ),
            'type'
        );
    }
}
