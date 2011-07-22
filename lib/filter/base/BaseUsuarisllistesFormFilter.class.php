<?php

/**
 * Usuarisllistes filter form base class.
 *
 * @package    intranet
 * @subpackage filter
 * @author     Albert Johé i Martí
 */
abstract class BaseUsuarisllistesFormFilter extends BaseFormFilterPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'Llistes_idLlistes' => new sfWidgetFormPropelChoice(array('model' => 'Llistes', 'add_empty' => true)),
      'Usuaris_UsuarisID' => new sfWidgetFormPropelChoice(array('model' => 'Usuaris', 'add_empty' => true)),
      'site_id'           => new sfWidgetFormFilterInput(),
    ));

    $this->setValidators(array(
      'Llistes_idLlistes' => new sfValidatorPropelChoice(array('required' => false, 'model' => 'Llistes', 'column' => 'idLlistes')),
      'Usuaris_UsuarisID' => new sfValidatorPropelChoice(array('required' => false, 'model' => 'Usuaris', 'column' => 'UsuariID')),
      'site_id'           => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
    ));

    $this->widgetSchema->setNameFormat('usuarisllistes_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'Usuarisllistes';
  }

  public function getFields()
  {
    return array(
      'idUsuarisLlistes'  => 'Number',
      'Llistes_idLlistes' => 'ForeignKey',
      'Usuaris_UsuarisID' => 'ForeignKey',
      'site_id'           => 'Number',
    );
  }
}
