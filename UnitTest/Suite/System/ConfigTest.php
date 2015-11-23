<?php
namespace SPHERE\UnitTest\Suite\System;

use SPHERE\System\Config\ConfigFactory;
use SPHERE\System\Config\Reader\ArrayReader;
use SPHERE\System\Config\Reader\IniReader;

/**
 * Class ConfigTest
 *
 * @package SPHERE\UnitTest\Suite\System
 */
class ConfigTest extends \PHPUnit_Framework_TestCase
{

    public function testReader()
    {

        $Mock = $this->getMockForAbstractClass('SPHERE\System\Config\Reader\AbstractReader');
        $this->assertInstanceOf('SPHERE\System\Config\ConfigInterface', $Mock);
        $this->assertInstanceOf('SPHERE\System\Config\Reader\ReaderInterface', $Mock);

        $Mock = new IniReader();
        $this->assertInstanceOf('SPHERE\System\Config\ConfigInterface', $Mock);
        $this->assertInstanceOf('SPHERE\System\Config\Reader\ReaderInterface', $Mock);

        $Mock = new ArrayReader();
        $this->assertInstanceOf('SPHERE\System\Config\ConfigInterface', $Mock);
        $this->assertInstanceOf('SPHERE\System\Config\Reader\ReaderInterface', $Mock);
    }

    public function testFactory()
    {

        $Mock = new ConfigFactory();
        $this->assertInstanceOf('SPHERE\System\Config\ConfigInterface', $Mock);

        // Ini Reader
        $Reader = $Mock->createReader( __DIR__.'/ConfigTest.ini', new IniReader());
        $this->assertInstanceOf('SPHERE\System\Config\Reader\ReaderInterface', $Reader);
        $this->assertInstanceOf('SPHERE\System\Config\Reader\IniReader', $Reader);

        $this->assertInstanceOf('SPHERE\System\Config\ConfigInterface', $Reader->getConfig());
        $this->assertInstanceOf('SPHERE\System\Config\ConfigContainer', $Reader->getConfig());

        $this->assertEquals( '0', $Reader->getConfig()->getContainer( 'Test1' )->getContainer( 'ValueA' )->getValue() );
        $this->assertEquals( '1.0', $Reader->getConfig()->getContainer( 'Test1' )->getContainer( 'ValueB' )->getValue() );
        $this->assertEquals( '2', $Reader->getConfig()->getContainer( 'Test1' )->getContainer( 'ValueC' )->getValue() );

        $this->assertEquals( '1', $Reader->getConfig()->getContainer( 'Test2' )->getContainer( 'ValueA' )->getValue() );
        $this->assertEquals( '', $Reader->getConfig()->getContainer( 'Test2' )->getContainer( 'ValueB' )->getValue() );
        $this->assertEquals( '', $Reader->getConfig()->getContainer( 'Test2' )->getContainer( 'ValueC' )->getValue() );

        // Array Reader
        $Reader = $Mock->createReader( parse_ini_file(__DIR__.'/ConfigTest.ini', true), new ArrayReader());
        $this->assertInstanceOf('SPHERE\System\Config\Reader\ReaderInterface', $Reader);
        $this->assertInstanceOf('SPHERE\System\Config\Reader\ArrayReader', $Reader);

        $this->assertInstanceOf('SPHERE\System\Config\ConfigInterface', $Reader->getConfig());
        $this->assertInstanceOf('SPHERE\System\Config\ConfigContainer', $Reader->getConfig());

        $this->assertEquals( '0', $Reader->getConfig()->getContainer( 'Test1' )->getContainer( 'ValueA' )->getValue() );
        $this->assertEquals( '1.0', $Reader->getConfig()->getContainer( 'Test1' )->getContainer( 'ValueB' )->getValue() );
        $this->assertEquals( '2', $Reader->getConfig()->getContainer( 'Test1' )->getContainer( 'ValueC' )->getValue() );

        $this->assertEquals( '1', $Reader->getConfig()->getContainer( 'Test2' )->getContainer( 'ValueA' )->getValue() );
        $this->assertEquals( '', $Reader->getConfig()->getContainer( 'Test2' )->getContainer( 'ValueB' )->getValue() );
        $this->assertEquals( '', $Reader->getConfig()->getContainer( 'Test2' )->getContainer( 'ValueC' )->getValue() );
    }
}
