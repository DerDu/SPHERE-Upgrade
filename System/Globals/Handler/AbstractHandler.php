<?php
namespace SPHERE\System\Globals\Handler;

use SPHERE\System\Config\ConfigContainer;
use SPHERE\System\Config\Reader\ReaderInterface;

/**
 * Class AbstractHandler
 * @package SPHERE\System\Globals\Handler
 */
abstract class AbstractHandler implements HandlerInterface
{
    /** @var ConfigContainer $Global */
    protected $Global = array();

    /**
     * @param ReaderInterface|null $Config
     * @return mixed
     */
    public function setConfig(ReaderInterface $Config = null)
    {
        $this->Global = $Config->getConfig();
    }

    /**
     * @return ConfigContainer
     */
    public function getConfig()
    {
        return $this->Global;
    }

    /**
     * @param string $Key
     * @return mixed
     */
    public function getValue($Key)
    {
        $Key = explode('.', $Key);
        $Container = $this->Global;
        array_walk($Key, function ($Key) use (&$Container) {
            if ($Container) {
                $Container = $Container->getContainer($Key);
            }
        });
        if( $Container instanceof ConfigContainer ) {
            return $Container->getValue();
        } else {
            return $Container;
        }
    }

    /**
     * @param string $Key
     * @param mixed $Value
     * @return mixed
     */
    public function setValue($Key, $Value)
    {

        $KeyList = explode('.', $Key);
        $Container = $this->Global;
        foreach( (array)$KeyList as $Key ) {
            if ($Container instanceof ConfigContainer) {
                if( null === $Container->getContainer($Key) ) {
                    var_dump( 'New '.$Key );
                    $Container->setContainer( $Key, new ConfigContainer(null) );
                }
                var_dump( 'Load '.$Key );
                $Container = $Container->getContainer($Key);
                var_dump( $Container );
            }
        }
        arsort
        var_dump( $this->Global );
        return $this;
    }
}
