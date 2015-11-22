<?php
namespace SPHERE\System\Authenticator\Handler;

use SPHERE\System\Authenticator\AuthenticatorInterface;
use SPHERE\System\Config\Reader\ReaderInterface;

/**
 * Interface HandlerInterface
 * @package SPHERE\System\Authenticator\Handler
 */
interface HandlerInterface extends AuthenticatorInterface
{
    /**
     * @param string $Name
     * @param ReaderInterface $Config
     * @return HandlerInterface
     */
    public function setConfig($Name, ReaderInterface $Config = null);

    /**
     * @return bool|null
     */
    public function validateSignature();

    /**
     * @param array       $Data
     * @param null|string $Location
     *
     * @return array
     */
    public function createSignature($Data, $Location = null);
}
