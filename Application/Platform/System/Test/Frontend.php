<?php
namespace SPHERE\Application\Platform\System\Test;

use MOC\V\Core\FileSystem\FileSystem;
use SPHERE\Application\Platform\System\Test\Service\Entity\TblTestPicture;
use SPHERE\Common\Frontend\Form\Repository\Button\Danger;
use SPHERE\Common\Frontend\Form\Repository\Button\Primary;
use SPHERE\Common\Frontend\Form\Repository\Button\Reset;
use SPHERE\Common\Frontend\Form\Repository\Button\Success;
use SPHERE\Common\Frontend\Form\Repository\Field\AutoCompleter;
use SPHERE\Common\Frontend\Form\Repository\Field\CheckBox;
use SPHERE\Common\Frontend\Form\Repository\Field\DatePicker;
use SPHERE\Common\Frontend\Form\Repository\Field\FileUpload;
use SPHERE\Common\Frontend\Form\Repository\Field\HiddenField;
use SPHERE\Common\Frontend\Form\Repository\Field\NumberField;
use SPHERE\Common\Frontend\Form\Repository\Field\PasswordField;
use SPHERE\Common\Frontend\Form\Repository\Field\RadioBox;
use SPHERE\Common\Frontend\Form\Repository\Field\SelectBox;
use SPHERE\Common\Frontend\Form\Repository\Field\TextArea;
use SPHERE\Common\Frontend\Form\Repository\Field\TextCaptcha;
use SPHERE\Common\Frontend\Form\Repository\Field\TextField;
use SPHERE\Common\Frontend\Form\Structure\Form;
use SPHERE\Common\Frontend\Form\Structure\FormColumn;
use SPHERE\Common\Frontend\Form\Structure\FormGroup;
use SPHERE\Common\Frontend\Form\Structure\FormRow;
use SPHERE\Common\Frontend\Icon\Repository\Disable;
use SPHERE\Common\Frontend\Icon\Repository\Ok;
use SPHERE\Common\Frontend\Icon\Repository\Time;
use SPHERE\Common\Frontend\Icon\Repository\Upload;
use SPHERE\Common\Frontend\IFrontendInterface;
use SPHERE\Common\Frontend\Layout\Repository\Badge;
use SPHERE\Common\Frontend\Layout\Repository\Container;
use SPHERE\Common\Frontend\Layout\Repository\Header;
use SPHERE\Common\Frontend\Layout\Repository\Label;
use SPHERE\Common\Frontend\Layout\Repository\Listing;
use SPHERE\Common\Frontend\Layout\Repository\Panel;
use SPHERE\Common\Frontend\Layout\Repository\Paragraph;
use SPHERE\Common\Frontend\Layout\Repository\PullRight;
use SPHERE\Common\Frontend\Layout\Repository\Thumbnail;
use SPHERE\Common\Frontend\Layout\Repository\Title;
use SPHERE\Common\Frontend\Layout\Repository\Well;
use SPHERE\Common\Frontend\Layout\Structure\Layout;
use SPHERE\Common\Frontend\Layout\Structure\LayoutColumn;
use SPHERE\Common\Frontend\Layout\Structure\LayoutGroup;
use SPHERE\Common\Frontend\Layout\Structure\LayoutRow;
use SPHERE\Common\Frontend\Layout\Structure\LayoutSocial;
use SPHERE\Common\Frontend\Layout\Structure\LayoutTab;
use SPHERE\Common\Frontend\Layout\Structure\LayoutTabs;
use SPHERE\Common\Frontend\Link\Repository\Standard;
use SPHERE\Common\Frontend\Table\Structure\TableData;
use SPHERE\Common\Frontend\Text\Repository\Warning;
use SPHERE\Common\Window\Navigation\Link\Route;
use SPHERE\Common\Window\Stage;
use SPHERE\System\Extension\Extension;

/**
 * Class Frontend
 *
 * @package SPHERE\Application\System\Platform\Test
 */
class Frontend extends Extension implements IFrontendInterface
{

    /**
     * @return Stage
     */
    public function frontendPlatform()
    {

        $Stage = new Stage('Test', 'Frontend');

        $Stage->setMessage('Message: Red alert.Processor of a distant x-ray vision, lower the death!Make it so, chemical wind!Fantastic nanomachines, to the alpha quadrant.Boldly sonic showers lead to the understanding.The death is a ship-wide cosmonaut.Wobble nosily like a post-apocalyptic space suit.Cosmonauts are the emitters of the fantastic ionic cannon.Where is the strange teleporter?');

        $Stage->addButton(
            new Standard('Link', new Route(__NAMESPACE__))
        );

        $Stage->setContent(
            (new Form(
                new FormGroup(array(
                    new FormRow(array(
                        new FormColumn(
                            new AutoCompleter('AutoCompleter', 'AutoCompleter', 'AutoCompleter',
                                array('123', '234', '345'))
                            , 3),
                        new FormColumn(array(
                            new CheckBox('CheckBox', 'CheckBox', 'c1'),
                            new RadioBox('RadioBox1', 'RadioBox1a', '1a'),
                        ), 3),
                        new FormColumn(
                            new DatePicker('DatePicker', 'DatePicker', 'DatePicker')
                            , 3),
                        new FormColumn(
                            new FileUpload('FileUpload', 'FileUpload', 'FileUpload')
                            , 3),
                    )),
                    new FormRow(array(
                        new FormColumn(
                            new HiddenField('HiddenField', 'HiddenField', 'HiddenField')
                            , 3),
                        new FormColumn(
                            new NumberField('NumberField', 'NumberField', 'NumberField')
                            , 3),
                        new FormColumn(
                            new PasswordField('PasswordField', 'PasswordField', 'PasswordField')
                            , 3),
                        new FormColumn(array(
                            new RadioBox('RadioBox1', 'RadioBox1b', '1b'),
                            new RadioBox('RadioBox2', 'RadioBox2', '2'),
                            new RadioBox('RadioBox3', 'RadioBox3', '3'),
                        ), 3),
                    )),
                    new FormRow(array(
                        new FormColumn(
                            new SelectBox('SelectBox', 'SelectBox',
                                array('0' => 'A', '2' => '1', '3' => '2', '4' => '3'))
                            , 3),
                        new FormColumn(
                            new TextArea('TextArea', 'TextArea', 'TextArea')
                            , 3),
                        new FormColumn(
                            new TextCaptcha('TextCaptcha', 'TextCaptcha', 'TextCaptcha')
                            , 3),
                        new FormColumn(
                            new TextField('TextField', 'TextField', 'TextField')
                            , 3),
                    )),
//                    new FormRow( array(
//                        new FormColumn(
//                            new \SPHERE\Common\Frontend\Form\Repository\Title('Title')
//                        ,3),
//                        new FormColumn(
//                            new Aspect('Aspect')
//                        ,3),
//                    ) )
                ), new \SPHERE\Common\Frontend\Form\Repository\Title('Form-Title')),
                array(
                    new Primary('Primary'),
                    new Danger('Danger'),
                    new Success('Success'),
                    new Reset('Reset')
                )
            ))->setConfirm('Wirklich?')
            .new Layout(array(
                new LayoutGroup(array(
                    new LayoutRow(array(
//                        new LayoutColumn( array(
//                            new Address( null )
//                        ), 3 ),
                        new LayoutColumn(array(
                            new Badge('Badge')
                        ), 3),
                        new LayoutColumn(array(
                            new Container('Container')
                        ), 3),
                        new LayoutColumn(array(
                            new Header('Header')
                        ), 3),
                    )),
                    new LayoutRow(array(
                        new LayoutColumn(array(
                            new Label('Label')
                        ), 3),
                        new LayoutColumn(array(
                            new Listing('Listing')
                        ), 3),
                        new LayoutColumn(array(
                            new Panel('Panel', array('Conten 1', 'Content 2', 'Content 3'),
                                Panel::PANEL_TYPE_DEFAULT, 'Footer')
                        ), 3),
                        new LayoutColumn(array(
                            new PullRight('PullRight')
                        ), 3),
                    )),
                    new LayoutRow(array(
                        new LayoutColumn(array(
                            new Thumbnail(
                                FileSystem::getFileLoader('/Common/Style/Resource/logo_kreide2.png'),
                                'Title', 'Description',
                                array(new \SPHERE\Common\Frontend\Link\Repository\Primary('Primary', ''))
                            )
                        ), 3),
                        new LayoutColumn(array(
                            new Well('Well', array())
                        ), 3),
                        new LayoutColumn(
                            new TableData(array(
                                array('A' => 1, 'B' => '2'),
                                array('A' => 2, 'B' => '34567890')
                            ))
                            , 6),

                    )),
                    new LayoutRow(array(
                        new LayoutColumn(array(
                            '<hr/>'
                        )),

                    )),

                ), new Title('Layout-Title')),
                new LayoutGroup(array(
                    new LayoutRow(array(
                        new LayoutColumn(new LayoutTabs(array(
                            new LayoutTab('Name1', 0),
                            new LayoutTab('Name2', 1),
                            new LayoutTab('Name3', 2),
                        )), 3),
                        new LayoutColumn(
                            (new LayoutSocial())
                                ->addMediaItem('Head1', new Paragraph('Content').new Paragraph('Content'), new Time())
                                ->addMediaItem('Head2', 'Content',
                                    '<img src="/Common/Style/Resource/logo_kreide2.png" class="image-responsive" style="width:20px;"/>',
                                    '', LayoutSocial::ALIGN_BOTTOM)
                                ->addMediaList(
                                    (new LayoutSocial())
                                        ->addMediaItem('Head2.1',
                                            new Well(new Paragraph('Content').new Paragraph('Content')),
                                            '<img src="/Common/Style/Resource/logo_kreide2.png" class="image-responsive" style="width:20px;"/>',
                                            '', LayoutSocial::ALIGN_TOP)
                                        ->addMediaItem('', new Well('Content'),
                                            '<img src="/Common/Style/Resource/logo_kreide2.png" class="image-responsive" style="width:20px;"/>',
                                            '', LayoutSocial::ALIGN_MIDDLE)
                                )
                            , 4),
                    )),

                ), new Title('Layout Development'))
            ))
        );

        return $Stage;
    }

    /**
     * @param $FileUpload
     *
     * @return Stage
     */
    public function frontendUpload($FileUpload)
    {

        $Stage = new Stage('Upload', 'Form-Test');

//        $DataList = scandir( __DIR__ );
//
//        foreach ($DataList as $Key => &$Data) {
//            if (strtolower( substr( $Data, -3 ) ) != 'png'
//                && strtolower( substr( $Data, -3 ) ) != 'jpg'
//                && strtolower( substr( $Data, -3 ) ) != 'gif'
//                && strtolower( substr( $Data, -4 ) ) != 'jpeg'
//            ) {
//                unset( $DataList[array_search( $Data, $DataList )] );
//            }
//        }
        $PictureList = Test::useService()->getTestPictureAll();

//        $Source = stream_get_contents($PictureList[0]->getImgData());

        //print '<img src="data:image/jpeg;base64,'.base64_encode($Source).'" class="img-responsive"/>';

//        $PictureList = array_values( $DataList );

        $Stage->setContent(
            Test::useService()->UploadNow(
                (new Form(
                    new FormGroup(
                        new FormRow(array(
                            new FormColumn(array(
                                new FileUpload('FileUpload', 'FileUpload', 'FileUpload')
                            ), 8)
                        ))
                    )
                ))->appendFormButton(new Primary('Hochladen', new Upload())), $FileUpload)
            .self::PictureShow($PictureList)
        );

        return $Stage;
    }

    /**
     * @param $PictureList
     *
     * @return Layout
     */
    public function PictureShow($PictureList)
    {

        if (!empty( $PictureList )) {
//            $this->getDebugger()->screenDump( $PictureList );
//            /** @var TblTestPicture $Picture */
//            foreach ($PictureList as $Key => &$Picture) {
////                $this->getDebugger()->screenDump($Picture);
//                $Picture = new LayoutColumn(array(
////                    '<div id="Thumb-'.$Key.'"></div>
////                    <script type="text/javascript">
////                        Client.Use("ModAlways", function()
////                        {
////                            jQuery("div#Thumb-'.$Key.'").load("/Api/Test/ShowThumbnail?Id='.$Picture->getId().'");
////                        });
////                    </script>'
//                    (new \SPHERE\Application\Api\Test\Frontend())->ShowThumbnail($Picture->getId())
//                ), 6);
//            }
//
//            return new Layout(
//                new LayoutGroup(new LayoutRow($PictureList))
//            );
            /** @var TblTestPicture $Picture */
            foreach ((array)$PictureList as $Index => $Picture) {
                $PictureList[$Index] = new LayoutColumn(array(
                    (new \SPHERE\Application\Api\Test\Frontend())->ShowThumbnail($Picture->getId(), true)
                ), 3);
            }
        } else {
            $PictureList = array(
                new LayoutColumn(
                    new Warning('Keine Bilder hinterlegt')
                )
            );
        }

        $LayoutRowList = array();
        $LayoutRowCount = 0;
        $LayoutRow = null;
        /**
         * @var LayoutColumn $Picture
         */
        foreach ($PictureList as $Picture) {
            if ($LayoutRowCount % 4 == 0) {
                $LayoutRow = new LayoutRow(array());
                $LayoutRowList[] = $LayoutRow;
            }
            $LayoutRow->addColumn($Picture);
            $LayoutRowCount++;
        }
        return new Layout(new LayoutGroup($LayoutRowList));

    }

    /**
     * @param $Id
     *
     * @return Stage
     */
    public function frontendPictureDeleteCheck($Id)
    {

        $Stage = new Stage();
        $Stage->setTitle('Bild');
        $Stage->setDescription('wirklich entfernen?');

        $Stage->setContent(
            new Layout(
                new LayoutGroup(
                    new LayoutRow(array(
                            new LayoutColumn(array(
                                (new \SPHERE\Application\Api\Test\Frontend())->ShowThumbnail($Id)
                            ), 4),
                            new LayoutColumn(array(
                                new \SPHERE\Common\Frontend\Message\Repository\Warning('Soll das Bild wirklich gelöscht werden?')
                            ,
                                new Standard('Löschen', '/Platform/System/Test/Upload/Delete', new Ok(),
                                    array('Id' => $Id))
                            ,
                                new Standard('Abbrechen', '/Platform/System/Test/Upload', new Disable())
                            ), 8)
                        )
                    ))
            )
        );
        return $Stage;
    }

    /**
     * @param $Id
     *
     * @return Stage
     */
    public function frontendPictureDelete($Id)
    {

        $Stage = new Stage();
        $Stage->setTitle('Bild');
        $Stage->setDescription('entfernen');

        $tblTestPicture = Test::useService()->getTestPictureById($Id);
        $Stage->setContent(Test::useService()->deleteTblTestPicture($tblTestPicture));

        return $Stage;
    }
}
