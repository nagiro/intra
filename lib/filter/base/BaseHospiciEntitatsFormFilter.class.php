<?php

/**
 * HospiciEntitats filter form base class.
 *
 * @package    intranet
 * @subpackage filter
 * @author     Albert Johé i Martí
 */
abstract class BaseHospiciEntitatsFormFilter extends BaseFormFilterPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'nom'        => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'descripcio' => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'habilitat'  => new sfWidgetFormFilterInput(array('with_empty' => false)),
    ));

    $this->setValidators(array(
      'nom'        => new sfValidatorPass(array('required' => false)),
      'descripcio' => new sfValidatorPass(array('required' => false)),
      'habilitat'  => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
    ));

    $this->widgetSchema->setNameFormat('hospici_entitats_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'HospiciEntitats';
  }

  public function getFields()
  {
    return array(
      'entitat_id' => 'Number',
      'nom'        => 'Text',
      'descripcio' => 'Text',
      'habilitat'  => 'Number',
    );
  }
}
