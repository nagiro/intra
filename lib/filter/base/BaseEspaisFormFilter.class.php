<?php

/**
 * Espais filter form base class.
 *
 * @package    intranet
 * @subpackage filter
 * @author     Albert Johé i Martí
 */
abstract class BaseEspaisFormFilter extends BaseFormFilterPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'Nom'     => new sfWidgetFormFilterInput(),
      'Ordre'   => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'site_id' => new sfWidgetFormFilterInput(),
    ));

    $this->setValidators(array(
      'Nom'     => new sfValidatorPass(array('required' => false)),
      'Ordre'   => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'site_id' => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
    ));

    $this->widgetSchema->setNameFormat('espais_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'Espais';
  }

  public function getFields()
  {
    return array(
      'EspaiID' => 'Number',
      'Nom'     => 'Text',
      'Ordre'   => 'Number',
      'site_id' => 'Number',
    );
  }
}
