<?php

/**
 * UsuarisApps form base class.
 *
 * @method UsuarisApps getObject() Returns the current form's model object
 *
 * @package    intranet
 * @subpackage form
 * @author     Your name here
 */
abstract class BaseUsuarisAppsForm extends BaseFormPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'usuari_id' => new sfWidgetFormInputHidden(),
      'app_id'    => new sfWidgetFormInputHidden(),
      'nivell_id' => new sfWidgetFormPropelChoice(array('model' => 'Nivells', 'add_empty' => true)),
      'site_id'   => new sfWidgetFormInputText(),
      'actiu'     => new sfWidgetFormInputText(),
    ));

    $this->setValidators(array(
      'usuari_id' => new sfValidatorPropelChoice(array('model' => 'Usuaris', 'column' => 'UsuariID', 'required' => false)),
      'app_id'    => new sfValidatorPropelChoice(array('model' => 'Apps', 'column' => 'app_id', 'required' => false)),
      'nivell_id' => new sfValidatorPropelChoice(array('model' => 'Nivells', 'column' => 'idNivells', 'required' => false)),
      'site_id'   => new sfValidatorInteger(array('min' => -128, 'max' => 127, 'required' => false)),
      'actiu'     => new sfValidatorInteger(array('min' => -128, 'max' => 127)),
    ));

    $this->widgetSchema->setNameFormat('usuaris_apps[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'UsuarisApps';
  }


}
