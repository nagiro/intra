<?php

/**
 * UsuarisApps filter form base class.
 *
 * @package    intranet
 * @subpackage filter
 * @author     Albert Johé i Martí
 */
abstract class BaseUsuarisAppsFormFilter extends BaseFormFilterPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'nivell_id' => new sfWidgetFormPropelChoice(array('model' => 'Nivells', 'add_empty' => true)),
      'site_id'   => new sfWidgetFormFilterInput(),
    ));

    $this->setValidators(array(
      'nivell_id' => new sfValidatorPropelChoice(array('required' => false, 'model' => 'Nivells', 'column' => 'idNivells')),
      'site_id'   => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
    ));

    $this->widgetSchema->setNameFormat('usuaris_apps_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'UsuarisApps';
  }

  public function getFields()
  {
    return array(
      'usuari_id' => 'ForeignKey',
      'app_id'    => 'ForeignKey',
      'nivell_id' => 'ForeignKey',
      'site_id'   => 'Number',
    );
  }
}
