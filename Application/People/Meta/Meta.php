<?php
namespace SPHERE\Application\People\Meta;

use SPHERE\Application\IApplicationInterface;
use SPHERE\Application\People\Meta\Common\Common;
use SPHERE\Application\People\Meta\Custody\Custody;
use SPHERE\Application\People\Meta\Prospect\Prospect;
use SPHERE\Application\People\Meta\Student\Student;
use SPHERE\Common\Window\Navigation\Link;

/**
 * Class Meta
 *
 * @package SPHERE\Application\People\Meta
 */
class Meta implements IApplicationInterface
{

    public static function registerApplication()
    {

        Common::registerModule();
        Prospect::registerModule();
        Student::registerModule();
        Custody::registerModule();
    }

}
