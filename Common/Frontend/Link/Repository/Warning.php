<?php
namespace SPHERE\Common\Frontend\Link\Repository;

use MOC\V\Component\Template\Component\IBridgeInterface;
use SPHERE\Common\Frontend\Icon\IIconInterface;
use SPHERE\Common\Frontend\Link\ILinkInterface;
use SPHERE\Common\Window\Navigation\Link\Route;
use SPHERE\System\Authenticator\Authenticator;
use SPHERE\System\Authenticator\Type\Get;
use SPHERE\System\Extension\Extension;

/**
 * Class Warning
 *
 * @package SPHERE\Common\Frontend\Link\Repository
 */
class Warning extends Extension implements ILinkInterface
{

    /** @var string $Name */
    protected $Name;
    /** @var IBridgeInterface $Template */
    protected $Template = null;

    /**
     * @param string         $Name
     * @param                $Path
     * @param IIconInterface $Icon
     * @param array          $Data
     * @param bool|string    $ToolTip
     */
    public function __construct($Name, $Path, IIconInterface $Icon = null, $Data = array(), $ToolTip = false)
    {

        $this->Name = $Name;
        if (false !== strpos($Path, '\\')) {
            $Path = new Route($Path);
        }
        $this->Template = $this->getTemplate(__DIR__.'/Link.twig');
        $this->Template->setVariable('ElementName', $Name);
        $this->Template->setVariable('ElementType', 'btn btn-warning');
        if (null !== $Icon) {
            $this->Template->setVariable('ElementIcon', $Icon);
        }
        if (!empty( $Data )) {
            $Signature = (new Authenticator(new Get()))->getAuthenticator();
            $Data = '?'.http_build_query($Signature->createSignature($Data, $Path));
        } else {
            $Data = '';
        }
        $this->Template->setVariable('ElementPath', $Path.$Data);
        $this->Template->setVariable('UrlBase', $this->getRequest()->getUrlBase());
        if ($ToolTip) {
            if (is_string($ToolTip)) {
                $this->Template->setVariable('ElementToolTip', $ToolTip);
            } else {
                $this->Template->setVariable('ElementToolTip', $Name);
            }
        }
    }

    /**
     * @return string
     */
    public function getName()
    {

        return $this->Name;
    }

    /**
     * @return string
     */
    public function __toString()
    {

        return $this->getContent();
    }

    /**
     * @return string
     */
    public function getContent()
    {

        return $this->Template->getContent();
    }
}
