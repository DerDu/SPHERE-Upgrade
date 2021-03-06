<?php
namespace SPHERE\System\Extension\Repository;

use SPHERE\System\Database\Fitting\Element;

/**
 * Class Debugger
 *
 * @package SPHERE\System\Extension\Repository
 */
class Debugger
{

    /** @var bool $Enabled */
    public static $Enabled = false;
    /** @var array $Protocol */
    private static $Protocol = array();
    /** @var int $Timestamp */
    private static $Timestamp = 0;
    /** @var int $TimeGap */
    private static $TimeGap = 0;

    /**
     *
     */
    final function __construct()
    {

        if (!self::$Timestamp) {
            self::$Timestamp = microtime(true);
        }
        if (!self::$TimeGap) {
            self::$TimeGap = microtime(true);
        }
    }

    /**
     * @param $__METHOD__
     */
    final public static function addMethodCall($__METHOD__)
    {

        self::addProtocol(self::splitNamespace($__METHOD__));
    }

    /**
     * @param string $Message
     * @param string $Icon
     */
    final public static function addProtocol($Message, $Icon = 'time')
    {

        $TimeGap = self::getTimeGap() - self::$TimeGap;

        $Status = 'muted';
        if ($TimeGap < 0.020 && $TimeGap >= 0.002) {
            $Status = 'success';
        }
        if ($TimeGap >= 0.020) {
            $Status = 'warning';
            $Icon = 'time';
        }
        if ($TimeGap >= 0.070) {
            $Status = 'danger';
            $Icon = 'warning-sign';
        }

        self::$Protocol[] = '<div class="text-'.$Status.' small">'
            .'&nbsp;<span class="glyphicon glyphicon-'.$Icon.'"></span>&nbsp;'.self::getRuntime()
            .'&nbsp;<span class="glyphicon glyphicon-transfer"></span>&nbsp;'
            .'<code>'.$Message.'</code>'
            .'</div>';

        self::$TimeGap = self::getTimeGap();
    }

    /**
     * @return float
     */
    final public static function getTimeGap()
    {

        return ( microtime(true) - self::$Timestamp );
    }

    /**
     * @return string
     */
    final public static function getRuntime()
    {

        return round(self::getTimeGap() * 1000, 0).'ms';
    }

    /**
     * @param string $Value
     *
     * @return string
     */
    final private static function splitNamespace($Value)
    {

        return str_replace(array('\\', '/'), array('\\&shy;', '/&shy;'), $Value);
    }

    /**
     * @param $__FILE__
     * @param $__LINE__
     */
    final public static function addFileLine($__FILE__, $__LINE__)
    {

        self::addProtocol($__FILE__.' : '.$__LINE__, 'file');
    }

    /**
     * @return string
     */
    final public static function getProtocol()
    {

        if (!self::$Enabled) {
            return '';
        }
        if (!empty( self::$Protocol )) {
            self::addProtocol('Done #'.count(self::$Protocol));
        }
        krsort(self::$Protocol);
        return implode('', self::$Protocol);
    }

    /**
     * screenDump( Content, Content, .. )
     *
     * @param mixed $Content
     */
    final public static function screenDump($Content)
    {

        $Content = func_get_args();
        foreach ((array)$Content as $Dump) {
            if (is_object($Dump)) {
                if ($Dump instanceof Element) {
                    $Dump = print_r($Dump->__toArray(), true);
                } else {
                    $Dump = print_r($Dump, true);
                }
            }
            if (is_array($Dump)) {
                $Dump = print_r($Dump, true);
            }
            if (null === $Dump) {
                $Dump = 'NULL';
            }
            self::addProtocol('ScreenDump: '.$Dump);
            print '<pre>'.$Dump.'</pre>';
        }
    }

    /**
     * protocolDump( Content, Content, .. )
     *
     * @param mixed $Content
     */
    final public static function protocolDump($Content)
    {

        $Content = func_get_args();
        foreach ((array)$Content as $Dump) {
            self::addProtocol($Dump);
        }
    }

    /**
     * @return bool
     */
    final public static function isActive()
    {

        return self::$Enabled;
    }
}
