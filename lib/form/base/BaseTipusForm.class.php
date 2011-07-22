<?php

/**
 * Tipus form base class.
 *
 * @method Tipus getObject() Returns the current form's model object
 *
 * @package    intranet
 * @subpackage form
 * @author     Your name here
 */
abstract class BaseTipusForm extends BaseFormPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'idTipus'   => new sfWidgetFormInputHidden(),
      'tipusNom'  => new sfWidgetFormTextarea(),
      'tipusDesc' => new sfWidgetFormTextarea(),
      'site_id'   => new sfWidgetFormInputText(),
    ));

    $this->setValidators(array(
      'idTipus'   => new sfValidatorChoice(array('choices' => array($this->getObject()->getIdtipus()), 'empty_value' => $this->getObject()->getIdtipus(), 'required' => false)),
      'tipusNom'  => new sfValidatorString(array('required' => false)),
      'tipusDesc' => new sfValidatorString(array('required' => false)),
      'site_id'   => new sfValidatorInteger(array('min' => -128, 'max' => 127, 'required' => false)),
    ));

    $this->widgetSchema->setNameFormat('tipus[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'Tipus';
  }


}
