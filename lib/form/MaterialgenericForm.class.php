<?php

/**
 * Materialgeneric form.
 *
 * @package    intranet
 * @subpackage form
 * @author     Albert Johé i Martí
 * @version    SVN: $Id: sfPropelFormTemplate.php 10377 2008-07-21 07:10:32Z dwhittle $
 */
class MaterialgenericForm extends BaseMaterialgenericForm
{
  public function setup()
  {
            
    $this->setWidgets(array(
      'idMaterialGeneric' => new sfWidgetFormChoice(array('choices'=>MaterialgenericPeer::select($this->getOption('IDS'),true))),
      'Nom'               => new sfWidgetFormInputText(),
      'site_id'           => new sfWidgetFormInputHidden(),
      'actiu'             => new sfWidgetFormInputHidden(),
    ));

    $this->setValidators(array(
      'idMaterialGeneric' => new sfValidatorChoice(array('choices' => array($this->getObject()->getIdmaterialgeneric()), 'empty_value' => $this->getObject()->getIdmaterialgeneric(), 'required' => false)),
      'Nom'               => new sfValidatorString(array('required' => false)),
      'site_id'           => new sfValidatorInteger(array('min' => -128, 'max' => 127, 'required' => false)),
      'actiu'             => new sfValidatorInteger(array('min' => -128, 'max' => 127)),
    ));

    $this->widgetSchema->setLabels(array(
      'idMaterialGeneric' => 'Material: ',
      'Nom'               => 'Nom: ',      
    ));

    $this->widgetSchema->setNameFormat('materialgeneric[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);
    
  }
}
