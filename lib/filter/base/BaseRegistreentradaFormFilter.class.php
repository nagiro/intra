<?php

/**
 * Registreentrada filter form base class.
 *
 * @package    intranet
 * @subpackage filter
 * @author     Albert Johé i Martí
 */
abstract class BaseRegistreentradaFormFilter extends BaseFormFilterPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'Projecte'          => new sfWidgetFormFilterInput(),
      'Dades'             => new sfWidgetFormFilterInput(),
    ));

    $this->setValidators(array(
      'Projecte'          => new sfValidatorPass(array('required' => false)),
      'Dades'             => new sfValidatorPass(array('required' => false)),
    ));

    $this->widgetSchema->setNameFormat('registreentrada_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'Registreentrada';
  }

  public function getFields()
  {
    return array(
      'RegistreEntradaID' => 'Number',
      'Projecte'          => 'Text',
      'Dades'             => 'Text',
    );
  }
}
