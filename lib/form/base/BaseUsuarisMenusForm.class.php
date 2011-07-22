<?php

/**
 * UsuarisMenus form base class.
 *
 * @method UsuarisMenus getObject() Returns the current form's model object
 *
 * @package    intranet
 * @subpackage form
 * @author     Your name here
 */
abstract class BaseUsuarisMenusForm extends BaseFormPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'usuari_id' => new sfWidgetFormInputHidden(),
      'menu_id'   => new sfWidgetFormInputHidden(),
      'site_id'   => new sfWidgetFormInputHidden(),
      'nivell_id' => new sfWidgetFormPropelChoice(array('model' => 'Nivells', 'add_empty' => false)),
      'actiu'     => new sfWidgetFormInputText(),
    ));

    $this->setValidators(array(
      'usuari_id' => new sfValidatorPropelChoice(array('model' => 'Usuaris', 'column' => 'UsuariID', 'required' => false)),
      'menu_id'   => new sfValidatorPropelChoice(array('model' => 'GestioMenus', 'column' => 'menu_id', 'required' => false)),
      'site_id'   => new sfValidatorChoice(array('choices' => array($this->getObject()->getSiteId()), 'empty_value' => $this->getObject()->getSiteId(), 'required' => false)),
      'nivell_id' => new sfValidatorPropelChoice(array('model' => 'Nivells', 'column' => 'idNivells')),
      'actiu'     => new sfValidatorInteger(array('min' => -128, 'max' => 127)),
    ));

    $this->widgetSchema->setNameFormat('usuaris_menus[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'UsuarisMenus';
  }


}
