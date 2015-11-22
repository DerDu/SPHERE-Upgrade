<?php
/**
 * Setup: Php
 */
header('Content-type: text/html; charset=utf-8');
error_reporting(E_ALL);
ini_set('display_errors', 1);
date_default_timezone_set('Europe/Berlin');
session_start();
session_write_close();
set_time_limit(240);
ob_implicit_flush();
ini_set('memory_limit', '1024M');

/**
 * Setup: Loader
 */
require_once( __DIR__.'/Library/MOC-V/Core/AutoLoader/AutoLoader.php' );

use MOC\V\Core\AutoLoader\AutoLoader;
use SPHERE\System\Authenticator\AuthenticatorFactory;
use SPHERE\System\Authenticator\Handler\GetHandler;
use SPHERE\System\Authenticator\Handler\PostHandler;
use SPHERE\System\Cache\CacheFactory;
use SPHERE\System\Cache\Handler\APCuHandler;
use SPHERE\System\Cache\Handler\MemcachedHandler;
use SPHERE\System\Cache\Handler\MemoryHandler;
use SPHERE\System\Cache\Handler\OpCacheHandler;
use SPHERE\System\Cache\Handler\SmartyHandler;
use SPHERE\System\Cache\Handler\TwigHandler;
use SPHERE\System\Config\ConfigFactory;
use SPHERE\System\Database\DatabaseFactory;
use SPHERE\System\Debugger\DebuggerFactory;
use SPHERE\System\Debugger\Logger\BenchmarkLogger;
use SPHERE\System\Debugger\Logger\ErrorLogger;
use SPHERE\System\Globals\GlobalsFactory;

AutoLoader::getNamespaceAutoLoader('MOC\V', __DIR__.'/Library/MOC-V');
AutoLoader::getNamespaceAutoLoader('SPHERE', __DIR__.'/', 'SPHERE');

print '<pre>';

$Value = null;

$Logger = (new DebuggerFactory())->createLogger();

$Reader = (new ConfigFactory())->createReader(__DIR__.'/System/Database/Database.ini');

$Connection = (new DatabaseFactory())->createConnection('Platform:System:Test', $Reader);
$Connection = (new DatabaseFactory())->createConnection('Platform:System:Protocol', $Reader);
$Connection = (new DatabaseFactory())->createConnection('Platform:Gatekeeper:Authorization:Consumer', $Reader);

$Connection = (new DatabaseFactory())->createConnection('Platform:Gatekeeper:Authorization:Token', $Reader);

$Connection = (new DatabaseFactory())->createConnection('Platform:Gatekeeper:Authorization:Account', $Reader);

$Connection = (new DatabaseFactory())->createConnection('Platform:Gatekeeper:Authorization:Access', $Reader);

$Global = (new GlobalsFactory())->createHandler( new \SPHERE\System\Globals\Handler\GetHandler() );
var_dump( $Global );
$Global = (new GlobalsFactory())->createHandler( new \SPHERE\System\Globals\Handler\PostHandler() );
var_dump( $Global );

echo implode("\n", array(
    implode("\n", (new DebuggerFactory())->createLogger(new BenchmarkLogger())->getLog()),
    implode("\n", (new DebuggerFactory())->createLogger(new ErrorLogger())->getLog()),
));

