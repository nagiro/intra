<?php

/**
 * Log form base class.
 *
 * @method Log getObject() Returns the current form's model object
 *
 * @package    intranet
 * @subpackage form
 * @author     Your name here
 */
abstract class BaseLogForm extends BaseFormPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'Id'          => new sfWidgetFormInputHidden(),
      'UsuariID'    => new sfWidgetFormPropelChoice(array('model' => 'Usuaris', 'add_empty' => true)),
      'Accio'       => new sfWidgetFormInputText(),
      'Model'       => new sfWidgetFormInputText(),
      'DadesBefore' => new sfWidgetFormTextarea(),
      'DadesAfter'  => new sfWidgetFormTextarea(),
      'Data'        => new sfWidgetFormDateTime(),
    ));

    $this->setValidators(array(
      'Id'          => new sfValidatorChoice(array('choices' => array($this->getObject()->getId()), 'empty_value' => $this->getObject()->getId(), 'required' => false)),
      'UsuariID'    => new sfValidatorPropelChoice(array('model' => 'Usuaris', 'column' => 'UsuariID', 'required' => false)),
      'Accio'       => new sfValidatorString(array('max_length' => 50)),
      'Model'       => new sfValidatorString(array('max_length' => 50)),
      'DadesBefore' => new sfValidatorString(array('required' => false)),
      'DadesAfter'  => new sfValidatorString(array('required' => false)),
      'Data'        => new sfValidatorDateTime(array('required' => false)),
    ));

    $this->widgetSchema->setNameFormat('log[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'Log';
  }


}
