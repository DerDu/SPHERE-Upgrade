<?php
namespace SPHERE\Application\Setting\Consumer\Responsibility;

use SPHERE\Application\IModuleInterface;
use SPHERE\Application\Platform\Gatekeeper\Authorization\Consumer\Consumer;
use SPHERE\Common\Frontend\Icon\Repository\Education;
use SPHERE\Common\Frontend\IFrontendInterface;
use SPHERE\Common\Main;
use SPHERE\Common\Window\Navigation\Link;
use SPHERE\System\Database\Link\Identifier;

/**
 * Class Responsibility
 *
 * @package SPHERE\Application\Setting\Consumer\Responsibility
 */
class Responsibility implements IModuleInterface
{

    public static function registerModule()
    {

        Main::getDisplay()->addModuleNavigation(
            new Link(new Link\Route(__NAMESPACE__), new Link\Name('Schulträger'),
                new Link\Icon(new Education()))
        );
        Main::getDispatcher()->registerRoute(
            Main::getDispatcher()->createRoute(__NAMESPACE__, '/Frontend::frontendDashboard')
        );
        Main::getDispatcher()->registerRoute(
            Main::getDispatcher()->createRoute(__NAMESPACE__.'/Create',
                __NAMESPACE__.'/Frontend::frontendResponsibilityCreate'
            )
                ->setParameterDefault('Responsibility', null)
        );
        Main::getDispatcher()->registerRoute(
            Main::getDispatcher()->createRoute(__NAMESPACE__.'/Delete',
                __NAMESPACE__.'/Frontend::frontendResponsibilityDelete'
            )
        );
        Main::getDispatcher()->registerRoute(
            Main::getDispatcher()->createRoute(__NAMESPACE__.'/Destroy',
                __NAMESPACE__.'/Frontend::frontendResponsibilityDestroy'
            )
                ->setParameterDefault('Id', null)
                ->setParameterDefault('Confirm', false)
        );
    }

    /**
     * @return Service
     */
    public static function useService()
    {

        return new Service(
            new Identifier('Setting', 'Consumer', 'Responsibility', null,
                Consumer::useService()->getConsumerBySession()),
            __DIR__.'/Service/Entity', __NAMESPACE__.'\Service\Entity'
        );
    }

    /**
     * @return IFrontendInterface
     */
    public static function useFrontend()
    {

        return new Frontend();
    }
}
