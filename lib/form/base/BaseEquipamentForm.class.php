<?php

/**
 * Equipament form base class.
 *
 * @method Equipament getObject() Returns the current form's model object
 *
 * @package    intranet
 * @subpackage form
 * @author     Your name here
 */
abstract class BaseEquipamentForm extends BaseFormPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'EquipamentID'       => new sfWidgetFormInputHidden(),
      'Factures_FacturaID' => new sfWidgetFormPropelChoice(array('model' => 'Factures', 'add_empty' => false)),
      'Tipus'              => new sfWidgetFormInputText(),
      'DataCompra'         => new sfWidgetFormDate(),
      'Dades'              => new sfWidgetFormTextarea(),
      'site_id'            => new sfWidgetFormInputText(),
    ));

    $this->setValidators(array(
      'EquipamentID'       => new sfValidatorChoice(array('choices' => array($this->getObject()->getEquipamentid()), 'empty_value' => $this->getObject()->getEquipamentid(), 'required' => false)),
      'Factures_FacturaID' => new sfValidatorPropelChoice(array('model' => 'Factures', 'column' => 'FacturaID')),
      'Tipus'              => new sfValidatorString(array('max_length' => 100, 'required' => false)),
      'DataCompra'         => new sfValidatorDate(array('required' => false)),
      'Dades'              => new sfValidatorString(array('required' => false)),
      'site_id'            => new sfValidatorInteger(array('min' => -128, 'max' => 127, 'required' => false)),
    ));

    $this->widgetSchema->setNameFormat('equipament[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'Equipament';
  }


}
