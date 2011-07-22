<?php

/**
 * Poblacions filter form base class.
 *
 * @package    intranet
 * @subpackage filter
 * @author     Albert Johé i Martí
 */
abstract class BasePoblacionsFormFilter extends BaseFormFilterPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'Nom'        => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'Comarca'    => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'CodiPostal' => new sfWidgetFormFilterInput(array('with_empty' => false)),
    ));

    $this->setValidators(array(
      'Nom'        => new sfValidatorPass(array('required' => false)),
      'Comarca'    => new sfValidatorPass(array('required' => false)),
      'CodiPostal' => new sfValidatorPass(array('required' => false)),
    ));

    $this->widgetSchema->setNameFormat('poblacions_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'Poblacions';
  }

  public function getFields()
  {
    return array(
      'idPoblacio' => 'Number',
      'Nom'        => 'Text',
      'Comarca'    => 'Text',
      'CodiPostal' => 'Text',
    );
  }
}
