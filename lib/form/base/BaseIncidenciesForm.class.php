<?php

/**
 * Incidencies form base class.
 *
 * @method Incidencies getObject() Returns the current form's model object
 *
 * @package    intranet
 * @subpackage form
 * @author     Your name here
 */
abstract class BaseIncidenciesForm extends BaseFormPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'idIncidencia'  => new sfWidgetFormInputHidden(),
      'quiinforma'    => new sfWidgetFormPropelChoice(array('model' => 'Usuaris', 'add_empty' => false)),
      'quiresol'      => new sfWidgetFormPropelChoice(array('model' => 'Usuaris', 'add_empty' => false)),
      'titol'         => new sfWidgetFormTextarea(),
      'descripcio'    => new sfWidgetFormTextarea(),
      'estat'         => new sfWidgetFormInputText(),
      'dataalta'      => new sfWidgetFormDate(),
      'dataresolucio' => new sfWidgetFormDate(),
      'site_id'       => new sfWidgetFormInputText(),
      'actiu'         => new sfWidgetFormInputText(),
    ));

    $this->setValidators(array(
      'idIncidencia'  => new sfValidatorChoice(array('choices' => array($this->getObject()->getIdincidencia()), 'empty_value' => $this->getObject()->getIdincidencia(), 'required' => false)),
      'quiinforma'    => new sfValidatorPropelChoice(array('model' => 'Usuaris', 'column' => 'UsuariID')),
      'quiresol'      => new sfValidatorPropelChoice(array('model' => 'Usuaris', 'column' => 'UsuariID')),
      'titol'         => new sfValidatorString(array('required' => false)),
      'descripcio'    => new sfValidatorString(array('required' => false)),
      'estat'         => new sfValidatorInteger(array('min' => -2147483648, 'max' => 2147483647)),
      'dataalta'      => new sfValidatorDate(),
      'dataresolucio' => new sfValidatorDate(array('required' => false)),
      'site_id'       => new sfValidatorInteger(array('min' => -128, 'max' => 127, 'required' => false)),
      'actiu'         => new sfValidatorInteger(array('min' => -128, 'max' => 127)),
    ));

    $this->widgetSchema->setNameFormat('incidencies[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'Incidencies';
  }


}
