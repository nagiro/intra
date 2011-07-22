<?php

/**
 * UsuarisMenus filter form base class.
 *
 * @package    intranet
 * @subpackage filter
 * @author     Albert Johé i Martí
 */
abstract class BaseUsuarisMenusFormFilter extends BaseFormFilterPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'nivell_id' => new sfWidgetFormPropelChoice(array('model' => 'Nivells', 'add_empty' => true)),
    ));

    $this->setValidators(array(
      'nivell_id' => new sfValidatorPropelChoice(array('required' => false, 'model' => 'Nivells', 'column' => 'idNivells')),
    ));

    $this->widgetSchema->setNameFormat('usuaris_menus_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'UsuarisMenus';
  }

  public function getFields()
  {
    return array(
      'usuari_id' => 'ForeignKey',
      'menu_id'   => 'ForeignKey',
      'site_id'   => 'Number',
      'nivell_id' => 'ForeignKey',
    );
  }
}
