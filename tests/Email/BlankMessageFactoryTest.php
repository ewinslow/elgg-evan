<?php
namespace Evan\Email;

use ElggUser as User;

class BlankMessageFactoryTest extends \PHPUnit_Framework_TestCase {
    function setUp() {
        if (!class_exists('ElggUser')) {
            $this->markTestSkipped('Need Elgg 1.10 to autoload classes via composer');
        }
    }
    
    function testGeneratesMessages() {
        $factory = new BlankMessageFactory();
        $user = new User();
        $message = $factory->createForUser($user);
        
        $this->assertNotNull($message);
    }
}

