<?php

/**
 * Personal form base class.
 *
 * @method Personal getObject() Returns the current form's model object
 *
 * @package    intranet
 * @subpackage form
 * @author     Your name here
 */
abstract class BasePersonalForm extends BaseFormPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'idPersonal'       => new sfWidgetFormInputHidden(),
      'idUsuari'         => new sfWidgetFormPropelChoice(array('model' => 'Usuaris', 'add_empty' => false)),
      'idData'           => new sfWidgetFormDate(),
      'tipus'            => new sfWidgetFormInputText(),
      'text'             => new sfWidgetFormTextarea(),
      'data_revisio'     => new sfWidgetFormDateTime(),
      'data_alta'        => new sfWidgetFormDateTime(),
      'data_baixa'       => new sfWidgetFormDate(),
      'usuariUpdateId'   => new sfWidgetFormPropelChoice(array('model' => 'Usuaris', 'add_empty' => true)),
      'site_id'          => new sfWidgetFormInputText(),
      'actiu'            => new sfWidgetFormInputText(),
      'data_finalitzada' => new sfWidgetFormDateTime(),
    ));

    $this->setValidators(array(
      'idPersonal'       => new sfValidatorChoice(array('choices' => array($this->getObject()->getIdpersonal()), 'empty_value' => $this->getObject()->getIdpersonal(), 'required' => false)),
      'idUsuari'         => new sfValidatorPropelChoice(array('model' => 'Usuaris', 'column' => 'UsuariID')),
      'idData'           => new sfValidatorDate(),
      'tipus'            => new sfValidatorInteger(array('min' => -128, 'max' => 127, 'required' => false)),
      'text'             => new sfValidatorString(array('required' => false)),
      'data_revisio'     => new sfValidatorDateTime(array('required' => false)),
      'data_alta'        => new sfValidatorDateTime(array('required' => false)),
      'data_baixa'       => new sfValidatorDate(array('required' => false)),
      'usuariUpdateId'   => new sfValidatorPropelChoice(array('model' => 'Usuaris', 'column' => 'UsuariID', 'required' => false)),
      'site_id'          => new sfValidatorInteger(array('min' => -128, 'max' => 127, 'required' => false)),
      'actiu'            => new sfValidatorInteger(array('min' => -128, 'max' => 127)),
      'data_finalitzada' => new sfValidatorDateTime(array('required' => false)),
    ));

    $this->widgetSchema->setNameFormat('personal[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'Personal';
  }


}
