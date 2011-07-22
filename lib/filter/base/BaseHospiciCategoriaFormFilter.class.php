<?php

/**
 * HospiciCategoria filter form base class.
 *
 * @package    intranet
 * @subpackage filter
 * @author     Albert Johé i Martí
 */
abstract class BaseHospiciCategoriaFormFilter extends BaseFormFilterPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'tipus'        => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'nom'          => new sfWidgetFormFilterInput(array('with_empty' => false)),
    ));

    $this->setValidators(array(
      'tipus'        => new sfValidatorPass(array('required' => false)),
      'nom'          => new sfValidatorPass(array('required' => false)),
    ));

    $this->widgetSchema->setNameFormat('hospici_categoria_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'HospiciCategoria';
  }

  public function getFields()
  {
    return array(
      'categoria_id' => 'Number',
      'tipus'        => 'Text',
      'nom'          => 'Text',
    );
  }
}
