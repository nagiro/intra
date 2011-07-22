<?php

/**
 * Cicles form base class.
 *
 * @method Cicles getObject() Returns the current form's model object
 *
 * @package    intranet
 * @subpackage form
 * @author     Your name here
 */
abstract class BaseCiclesForm extends BaseFormPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'CicleID'  => new sfWidgetFormInputHidden(),
      'Nom'      => new sfWidgetFormTextarea(),
      'Imatge'   => new sfWidgetFormInputText(),
      'PDF'      => new sfWidgetFormInputText(),
      'tCurt'    => new sfWidgetFormTextarea(),
      'dCurt'    => new sfWidgetFormTextarea(),
      'tMig'     => new sfWidgetFormTextarea(),
      'dMig'     => new sfWidgetFormTextarea(),
      'tComplet' => new sfWidgetFormTextarea(),
      'dComplet' => new sfWidgetFormTextarea(),
      'extingit' => new sfWidgetFormInputText(),
      'site_id'  => new sfWidgetFormInputText(),
      'actiu'    => new sfWidgetFormInputText(),
    ));

    $this->setValidators(array(
      'CicleID'  => new sfValidatorChoice(array('choices' => array($this->getObject()->getCicleid()), 'empty_value' => $this->getObject()->getCicleid(), 'required' => false)),
      'Nom'      => new sfValidatorString(array('required' => false)),
      'Imatge'   => new sfValidatorString(array('max_length' => 255)),
      'PDF'      => new sfValidatorString(array('max_length' => 255)),
      'tCurt'    => new sfValidatorString(),
      'dCurt'    => new sfValidatorString(),
      'tMig'     => new sfValidatorString(),
      'dMig'     => new sfValidatorString(),
      'tComplet' => new sfValidatorString(),
      'dComplet' => new sfValidatorString(),
      'extingit' => new sfValidatorInteger(array('min' => -128, 'max' => 127)),
      'site_id'  => new sfValidatorInteger(array('min' => -128, 'max' => 127, 'required' => false)),
      'actiu'    => new sfValidatorInteger(array('min' => -128, 'max' => 127)),
    ));

    $this->widgetSchema->setNameFormat('cicles[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'Cicles';
  }


}
