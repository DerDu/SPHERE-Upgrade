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

        $Handler = $Mock->createHandler(new GetHandler());
        $this->assertInstanceOf('SPHERE\System\Globals\Handler\HandlerInterface', $Handler);
        $this->assertInstanceOf('SPHERE\System\Globals\Handler\GetHandler', $Handler);

        $this->assertInstanceOf('SPHERE\System\Config\ConfigInterface', $Handler->getConfig());
        $this->assertInstanceOf('SPHERE\System\Config\ConfigContainer', $Handler->getConfig());

        $Handler->setValue('Test1.TestA','Value1');
        $Handler->setValue('Test1.TestB','Value2');
//        $Handler->setValue('Test1.TestB.Test1','Value3');
//        var_dump( $Handler->getValue('Test1') );

        $Handler = $Mock->createHandler(new PostHandler());
        $this->assertInstanceOf('SPHERE\System\Globals\Handler\HandlerInterface', $Handler);
        $this->assertInstanceOf('SPHERE\System\Globals\Handler\PostHandler', $Handler);

        $this->assertInstanceOf('SPHERE\System\Config\ConfigInterface', $Handler->getConfig());
        $this->assertInstanceOf('SPHERE\System\Config\ConfigContainer', $Handler->getConfig());
    }
}
