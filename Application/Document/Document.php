<?php
namespace SPHERE\Application\Document;

use SPHERE\Application\Document\Designer\Designer;
use SPHERE\Application\Document\Explorer\Explorer;
use SPHERE\Application\Document\Search\Search;
use SPHERE\Application\IClusterInterface;
use SPHERE\Common\Main;
use SPHERE\Common\Window\Navigation\Link;
use SPHERE\Common\Window\Stage;
use SPHERE\System\Extension\Extension;

/**
 * Class Document
 *
 * @package SPHERE\Application\Document
 */
class Document extends Extension implements IClusterInterface
{

    public static function registerCluster()
    {

        Search::registerApplication();
        Explorer::registerApplication();
        Designer::registerApplication();

        Main::getDisplay()->addClusterNavigation(
            new Link(new Link\Route(__NAMESPACE__), new Link\Name('Dokumente'))
        );
        Main::getDispatcher()->registerRoute(Main::getDispatcher()->createRoute(
            __NAMESPACE__, __CLASS__.'::frontendDashboard'
        ));
    }

    /**
     * @return Stage
     */
    public function frontendDashboard()
    {

        $Stage = new Stage('Dashboard', 'Dokumente');

        return $Stage;
    }
}
