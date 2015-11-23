<?php
namespace SPHERE\UnitTest\Suite\System;

use SPHERE\System\Globals\GlobalsFactory;
use SPHERE\System\Globals\Handler\GetHandler;
use SPHERE\System\Globals\Handler\PostHandler;

/**
 * Class GlobalsTest
 * @package SPHERE\UnitTest\Suite\System
 */
class GlobalsTest extends \PHPUnit_Framework_TestCase
{
    public function testHandler()
    {
        $Mock = $this->getMockForAbstractClass('SPHERE\System\Globals\Handler\AbstractHandler');
        $this->assertInstanceOf('SPHERE\System\Globals\GlobalsInterface', $Mock);
        $this->assertInstanceOf('SPHERE\System\Globals\Handler\HandlerInterface', $Mock);

        $Mock = new GetHandler();
        $this->assertInstanceOf('SPHERE\System\Globals\GlobalsInterface', $Mock);
        $this->assertInstanceOf('SPHERE\System\Globals\Handler\HandlerInterface', $Mock);

        $Mock = new PostHandler();
        $this->assertInstanceOf('SPHERE\System\Globals\GlobalsInterface', $Mock);
        $this->assertInstanceOf('SPHERE\System\Globals\Handler\HandlerInterface', $Mock);
    }

    public function testFactory()
    {
        $Mock = new GlobalsFactory();
        $this->assertInstanceOf('SPHERE\System\Globals\GlobalsInterface', $Mock);

        $_GET = parse_ini_file(__DIR__.'/ConfigTest.ini', true);

        $Handler = $Mock->createHandler(new GetHandler());
        $this->assertInstanceOf('SPHERE\System\Globals\Handler\HandlerInterface', $Handler);
        $this->assertInstanceOf('SPHERE\System\Globals\Handler\GetHandler', $Handler);

        $this->assertInstanceOf('SPHERE\System\Config\ConfigInterface', $Handler->getConfig());
        $this->assertInstanceOf('SPHERE\System\Config\ConfigContainer', $Handler->getConfig());

        $this->assertEquals( '0', $Handler->getConfig()->getContainer( 'Test1' )->getContainer( 'ValueA' )->getValue() );
        $this->assertEquals( '0', $Handler->getValue( 'Test1.ValueA' ) );
        $this->assertEquals( '1.0', $Handler->getConfig()->getContainer( 'Test1' )->getContainer( 'ValueB' )->getValue() );
        $this->assertEquals( '1.0', $Handler->getValue( 'Test1.ValueB' ) );
        $this->assertEquals( '2', $Handler->getConfig()->getContainer( 'Test1' )->getContainer( 'ValueC' )->getValue() );
        $this->assertEquals( '2', $Handler->getValue( 'Test1.ValueC' ) );

        $this->assertEquals( '1', $Handler->getConfig()->getContainer( 'Test2' )->getContainer( 'ValueA' )->getValue() );
        $this->assertEquals( '1', $Handler->getValue( 'Test2.ValueA' ) );
        $this->assertEquals( '', $Handler->getConfig()->getContainer( 'Test2' )->getContainer( 'ValueB' )->getValue() );
        $this->assertEquals( '', $Handler->getValue( 'Test2.ValueB' ) );
        $this->assertEquals( '', $Handler->getConfig()->getContainer( 'Test2' )->getContainer( 'ValueC' )->getValue() );
        $this->assertEquals( '', $Handler->getValue( 'Test2.ValueC' ) );

        $Handler->setValue( 'Test1.ValueD.ValueE', 'X' );

        $_POST = parse_ini_file(__DIR__.'/ConfigTest.ini', true);

        $Handler = $Mock->createHandler(new PostHandler());
        $this->assertInstanceOf('SPHERE\System\Globals\Handler\HandlerInterface', $Handler);
        $this->assertInstanceOf('SPHERE\System\Globals\Handler\PostHandler', $Handler);

        $this->assertInstanceOf('SPHERE\System\Config\ConfigInterface', $Handler->getConfig());
        $this->assertInstanceOf('SPHERE\System\Config\ConfigContainer', $Handler->getConfig());

        $this->assertEquals( '0', $Handler->getConfig()->getContainer( 'Test1' )->getContainer( 'ValueA' )->getValue() );
        $this->assertEquals( '0', $Handler->getValue( 'Test1.ValueA' ) );
        $this->assertEquals( '1.0', $Handler->getConfig()->getContainer( 'Test1' )->getContainer( 'ValueB' )->getValue() );
        $this->assertEquals( '1.0', $Handler->getValue( 'Test1.ValueB' ) );
        $this->assertEquals( '2', $Handler->getConfig()->getContainer( 'Test1' )->getContainer( 'ValueC' )->getValue() );
        $this->assertEquals( '2', $Handler->getValue( 'Test1.ValueC' ) );

        $this->assertEquals( '1', $Handler->getConfig()->getContainer( 'Test2' )->getContainer( 'ValueA' )->getValue() );
        $this->assertEquals( '1', $Handler->getValue( 'Test2.ValueA' ) );
        $this->assertEquals( '', $Handler->getConfig()->getContainer( 'Test2' )->getContainer( 'ValueB' )->getValue() );
        $this->assertEquals( '', $Handler->getValue( 'Test2.ValueB' ) );
        $this->assertEquals( '', $Handler->getConfig()->getContainer( 'Test2' )->getContainer( 'ValueC' )->getValue() );
        $this->assertEquals( '', $Handler->getValue( 'Test2.ValueC' ) );
    }
}
