<?php

/**
 * UsuarisSites filter form base class.
 *
 * @package    intranet
 * @subpackage filter
 * @author     Albert Johé i Martí
 */
abstract class BaseUsuarisSitesFormFilter extends BaseFormFilterPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'nivell_id' => new sfWidgetFormPropelChoice(array('model' => 'Nivells', 'add_empty' => true)),
      'actiu'     => new sfWidgetFormFilterInput(array('with_empty' => false)),
    ));

    $this->setValidators(array(
      'nivell_id' => new sfValidatorPropelChoice(array('required' => false, 'model' => 'Nivells', 'column' => 'idNivells')),
      'actiu'     => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
    ));

    $this->widgetSchema->setNameFormat('usuaris_sites_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'UsuarisSites';
  }

  public function getFields()
  {
    return array(
      'usuari_id' => 'ForeignKey',
      'site_id'   => 'ForeignKey',
      'nivell_id' => 'ForeignKey',
      'actiu'     => 'Number',
    );
  }
}
