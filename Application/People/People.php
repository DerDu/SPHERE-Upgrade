<?php
namespace SPHERE\Application\People;

use SPHERE\Application\IClusterInterface;
use SPHERE\Application\People\Group\Group;
use SPHERE\Application\People\Group\Service\Entity\TblGroup;
use SPHERE\Application\People\Meta\Meta;
use SPHERE\Application\People\Person\Person;
use SPHERE\Application\People\Relationship\Relationship;
use SPHERE\Application\People\Search\Search;
use SPHERE\Common\Frontend\Layout\Repository\Panel;
use SPHERE\Common\Frontend\Layout\Repository\PullRight;
use SPHERE\Common\Frontend\Layout\Structure\Layout;
use SPHERE\Common\Frontend\Layout\Structure\LayoutColumn;
use SPHERE\Common\Frontend\Layout\Structure\LayoutGroup;
use SPHERE\Common\Frontend\Layout\Structure\LayoutRow;
use SPHERE\Common\Frontend\Link\Repository\Standard;
use SPHERE\Common\Frontend\Text\Repository\Muted;
use SPHERE\Common\Frontend\Text\Repository\Small;
use SPHERE\Common\Main;
use SPHERE\Common\Window\Navigation\Link;
use SPHERE\Common\Window\Stage;

/**
 * Class People
 *
 * @package SPHERE\Application\People
 */
class People implements IClusterInterface
{

    public static function registerCluster()
    {

        Search::registerApplication();
        Person::registerApplication();
        Group::registerApplication();
        Meta::registerApplication();
        Relationship::registerApplication();

        Main::getDisplay()->addClusterNavigation(
            new Link(new Link\Route(__NAMESPACE__), new Link\Name('Personen'))
        );
        Main::getDispatcher()->registerRoute(Main::getDispatcher()->createRoute(
            __NAMESPACE__, __CLASS__.'::frontendDashboard'
        ));

        $tblGroupAll = Group::useService()->getGroupAll();
        if ($tblGroupAll) {
            /** @var TblGroup $tblGroup */
            foreach ((array)$tblGroupAll as $Index => $tblGroup) {
                $tblGroupAll[$tblGroup->getName()] =
                    new Layout(new LayoutGroup(new LayoutRow(array(
                            new LayoutColumn(
                                $tblGroup->getName()
                                .new Muted(new Small('<br/>'.$tblGroup->getDescription()))
                                , array(9, 0, 7)),
                            new LayoutColumn(
                                new Muted(new Small(Group::useService()->countPersonAllByGroup($tblGroup).'&nbsp;Mitglieder'))
                                , 2, array(LayoutColumn::GRID_OPTION_HIDDEN_SM, LayoutColumn::GRID_OPTION_HIDDEN_XS)),
                            new LayoutColumn(
                                new PullRight(
                                    new Standard('', '/People/Search/Group',
                                        new \SPHERE\Common\Frontend\Icon\Repository\Group(),
                                        array('Id' => $tblGroup->getId()),
                                        'zur Gruppe')
                                ), array(3, 0, 3))
                        )
                    )));
                $tblGroupAll[$Index] = false;
            }
            $tblGroupAll = array_filter($tblGroupAll);
            Main::getDispatcher()->registerWidget('Personen', new Panel('Personen in Gruppen', $tblGroupAll), 4, 6);
        }

        Main::getDispatcher()->registerWidget('Personen',
            new Panel('Anzahl an Personen', 'Insgesamt: '.Person::useService()->countPersonAll())
        );
    }

    /**
     * @return Stage
     */
    public function frontendDashboard()
    {

        $Stage = new Stage('Dashboard', 'Personen');

        $Stage->setContent(Main::getDispatcher()->fetchDashboard('Personen'));

        return $Stage;
    }
}
