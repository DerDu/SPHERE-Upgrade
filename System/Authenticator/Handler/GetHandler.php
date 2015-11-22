<?php
namespace SPHERE\System\Authenticator\Handler;

use SPHERE\System\Globals\GlobalsFactory;

/**
 * Class GetHandler
 * @package SPHERE\System\Authenticator\Handler
 */
class GetHandler extends AbstractHandler implements HandlerInterface
{
    /**
     * @return bool|null
     */
    public function validateSignature()
    {

        $Global = (new GlobalsFactory())->createHandler(new \SPHERE\System\Globals\Handler\GetHandler());
        var_dump( $Global );

//        array_walk_recursive($Global->getConfig(), array($this, 'preventXSS'));

        if (!empty( $Global->getConfig() ) && !isset( (string)$Global->getValue(['_Sign']) )) {
            $Global->GET = array();
            $Global->saveGet();
            return null;
        } else {
            if (isset( $Global->GET['_Sign'] )) {
                $Data = $Global->GET;
                $Signature = $Global->GET['_Sign'];
                unset( $Data['_Sign'] );
                $Check = $this->createSignature($Data);
                if ($Check['_Sign'] == $Signature) {
                    unset( $Global->GET['_Sign'] );
                    $Global->saveGet();
                    return true;
                } else {
                    $Global->GET = array();
                    $Global->saveGet();
                    return false;
                }
            } else {
                $Global->GET = array();
                $Global->saveGet();
                return true;
            }
        }
    }

    /**
     * @param array       $Data
     * @param null|string $Location
     *
     * @return array
     */
    public function createSignature($Data, $Location = null)
    {

        if (null === $Location) {
            $Location = $this->getRequest()->getPathInfo();
        }
        $Nonce = date('Ymd');
        array_push($Data, $Location);
        $Ordered = $this->sortData((array)$Data);
        $Signature = serialize($Ordered);
        $Signature = hash_hmac('sha256', $Signature, $Nonce.$this->Secret);
        array_pop($Data);
        $Data['_Sign'] = base64_encode($Signature);
        return $Data;
    }

    /**
     * @param $Data
     *
     * @return mixed
     */
    private function sortData($Data)
    {

        array_walk($Data, function (&$V) {

            if (!is_string($V) && !is_array($V)) {
                $V = (string)$V;
            }
        });
        krsort($Data);
        return $Data;
    }
}
