<?php
namespace SPHERE\System\Authenticator\Handler;

/**
 * Class PostHandler
 * @package SPHERE\System\Authenticator\Handler
 */
class PostHandler extends AbstractHandler implements HandlerInterface
{
    /**
     * @return bool|null
     */
    public function validateSignature()
    {

        $Global = $this->getGlobal();
        array_walk_recursive($Global->POST, array($this, 'preventXSS'));
        $Global->savePost();

        return true;
    }

    /**
     * @param array       $Data
     * @param null|string $Location
     *
     * @return array
     */
    public function createSignature($Data, $Location = null)
    {
        // TODO: Implement createSignature() method.
    }
}
