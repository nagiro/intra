<?php

/**
 * Tasques form base class.
 *
 * @method Tasques getObject() Returns the current form's model object
 *
 * @package    intranet
 * @subpackage form
 * @author     Your name here
 */
abstract class BaseTasquesForm extends BaseFormPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'TasquesID'              => new sfWidgetFormInputHidden(),
      'Activitats_ActivitatID' => new sfWidgetFormPropelChoice(array('model' => 'Activitats', 'add_empty' => true)),
      'QuiMana'                => new sfWidgetFormPropelChoice(array('model' => 'Usuaris', 'add_empty' => true)),
      'QuiFa'                  => new sfWidgetFormPropelChoice(array('model' => 'Usuaris', 'add_empty' => false)),
      'Titol'                  => new sfWidgetFormTextarea(),
      'Accio'                  => new sfWidgetFormTextarea(),
      'Reaccio'                => new sfWidgetFormTextarea(),
      'Estat'                  => new sfWidgetFormInputText(),
      'Aparicio'               => new sfWidgetFormDate(),
      'Desaparicio'            => new sfWidgetFormDate(),
      'DataResolucio'          => new sfWidgetFormDateTime(),
      'isFeta'                 => new sfWidgetFormInputText(),
      'AltaRegistre'           => new sfWidgetFormDate(),
    ));

    $this->setValidators(array(
      'TasquesID'              => new sfValidatorChoice(array('choices' => array($this->getObject()->getTasquesid()), 'empty_value' => $this->getObject()->getTasquesid(), 'required' => false)),
      'Activitats_ActivitatID' => new sfValidatorPropelChoice(array('model' => 'Activitats', 'column' => 'ActivitatID', 'required' => false)),
      'QuiMana'                => new sfValidatorPropelChoice(array('model' => 'Usuaris', 'column' => 'UsuariID', 'required' => false)),
      'QuiFa'                  => new sfValidatorPropelChoice(array('model' => 'Usuaris', 'column' => 'UsuariID')),
      'Titol'                  => new sfValidatorString(array('required' => false)),
      'Accio'                  => new sfValidatorString(array('required' => false)),
      'Reaccio'                => new sfValidatorString(array('required' => false)),
      'Estat'                  => new sfValidatorString(array('max_length' => 1, 'required' => false)),
      'Aparicio'               => new sfValidatorDate(array('required' => false)),
      'Desaparicio'            => new sfValidatorDate(array('required' => false)),
      'DataResolucio'          => new sfValidatorDateTime(array('required' => false)),
      'isFeta'                 => new sfValidatorInteger(array('min' => -128, 'max' => 127, 'required' => false)),
      'AltaRegistre'           => new sfValidatorDate(array('required' => false)),
    ));

    $this->widgetSchema->setNameFormat('tasques[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'Tasques';
  }


}
