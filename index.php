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
require_once(__DIR__ . '/Library/MOC-V/Core/AutoLoader/AutoLoader.php');

use MOC\V\Core\AutoLoader\AutoLoader;
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

AutoLoader::getNamespaceAutoLoader('MOC\V', __DIR__ . '/Library/MOC-V');
AutoLoader::getNamespaceAutoLoader('SPHERE', __DIR__ . '/', 'SPHERE');

print '<pre>';

$Value = null;

$Logger = (new DebuggerFactory())->createLogger();
/*
$Reader = (new ConfigFactory())->createReader(__DIR__ . '/System/Cache.ini');

$Handler = (new CacheFactory())->createHandler(new MemoryHandler());

$Handler->clearCache();
$Logger->addLog('Set Value (Cache): Test');
$Value = $Handler->setValue('Test', '456');

$Logger->addLog('Get Value (Cache): Test');
$Value = $Handler->getValue('Test');
$Logger->addLog($Value);

$Handler = (new CacheFactory())->createHandler(new MemcachedHandler(), $Reader);
$Handler->clearCache();

$Logger->addLog('Set Value (Cache): Test');
$Value = $Handler->setValue('Test', '456');

$Logger->addLog('Get Value (Cache): Test');
$Value = $Handler->getValue('Test');
$Logger->addLog($Value);

$Handler = (new CacheFactory())->createHandler(new OpCacheHandler(), $Reader);
$Handler->clearCache();

$Handler = (new CacheFactory())->createHandler(new APCuHandler(), $Reader);
$Handler->clearCache();

$Handler = (new CacheFactory())->createHandler(new SmartyHandler(), $Reader);
$Handler->clearCache();

$Handler = (new CacheFactory())->createHandler(new TwigHandler(), $Reader);
$Handler->clearCache();
*/
$Reader = (new ConfigFactory())->createReader(__DIR__ . '/System/Database/Database.ini');

$Connection = (new DatabaseFactory())->createConnection('Platform:System:Test', $Reader);
$Connection = (new DatabaseFactory())->createConnection('Platform:System:Protocol', $Reader);
$Connection = (new DatabaseFactory())->createConnection('Platform:Gatekeeper:Authorization:Consumer', $Reader);

var_dump( $Connection->createEntityManager(
    '/Application/Platform/Gatekeeper/Authorization/Consumer/Service/Entity',
    'SPHERE\Application\Platform\Gatekeeper\Authorization\Consumer\Service\Entity'
) );

$Connection = (new DatabaseFactory())->createConnection('Platform:Gatekeeper:Authorization:Token', $Reader);
$Connection = (new DatabaseFactory())->createConnection('Platform:Gatekeeper:Authorization:Account', $Reader);
$Connection = (new DatabaseFactory())->createConnection('Platform:Gatekeeper:Authorization:Access', $Reader);

echo implode("\n", (new DebuggerFactory())->createLogger(new BenchmarkLogger())->getLog());
echo implode("\n", (new DebuggerFactory())->createLogger(new ErrorLogger())->getLog());
