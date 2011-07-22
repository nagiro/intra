<?php

/**
 * Espais form.
 *
 * @package    intranet
 * @subpackage form
 * @author     Albert Johé i Martí
 * @version    SVN: $Id: sfPropelFormTemplate.php 10377 2008-07-21 07:10:32Z dwhittle $
 */
class EspaisForm extends BaseEspaisForm
{
    
  public function setup()
  {
    
    $this->WEB_IMATGE = 'images/espais/';   	    
    $Sino = array(0=>'No',1=>'SÃ­');
    $this->IDS = $this->getOption('IDS');
    
    $this->setWidgets(array(
      'EspaiID'     => new sfWidgetFormChoice(array('choices'=>EspaisPeer::select($this->IDS,true)),array()),
      'Nom'         => new sfWidgetFormInputText(array(),array('style'=>'width:400px')),
      'Ordre'       => new sfWidgetFormInputText(array(),array('style'=>'width:50px')),
      'site_id'     => new sfWidgetFormInputHidden(),
      'actiu'       => new sfWidgetFormInputHidden(),
      'isLlogable'  => new sfWidgetFormChoice(array('choices'=>$Sino)),
      'descripcio'  => new sfWidgetFormTextareaTinyMCE(array(),array()), 
    ));

    $this->setValidators(array(
      'EspaiID' => new sfValidatorPass(),
      'Nom'     => new sfValidatorString(array('max_length' => 50, 'required' => false)),
      'Ordre'   => new sfValidatorInteger(array('min' => -32768, 'max' => 32767)),
      'site_id' => new sfValidatorInteger(array('min' => -128, 'max' => 127, 'required' => false)),
      'actiu'   => new sfValidatorInteger(array('min' => -128, 'max' => 127)),
      'isLlogable'=> new sfValidatorPass(array(),array()),
      'descripcio' => new sfValidatorString(array('required'=>false),array()),             
    ));

    $this->widgetSchema->setNameFormat('espais[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);
    
    $this->widgetSchema->setLabels(array(
      'EspaiID' => 'Espai ',
      'Nom'     => 'Nom ',
      'Ordre'   => 'Ordre ',      
      'isLlogable' => 'Es lloga?',
      'descripcio' => 'DescripciÃ³ ',      
    ));
              
  }

  public function getModelName()
  {
    return 'Espais';
  }

  public function getFotosEspais()
  {
    $OE = $this->getObject();
    $LOM = MultimediaPeer::getFotosEspais( $OE->getEspaiid(), $OE->getSiteId());
    $RET = array();
    $i = 0;
    foreach($LOM as $OM):
        $RET[] = MultimediaPeer::initialize($OM->getMultimediaId(),$OM->getSiteId(),EspaisPeer::TABLE_NAME,$OE->getEspaiid(),$i++);
    endforeach;
    return $RET;
  }

}
