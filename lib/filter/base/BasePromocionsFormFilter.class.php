<?php

/**
 * Promocions filter form base class.
 *
 * @package    intranet
 * @subpackage filter
 * @author     Albert Johé i Martí
 */
abstract class BasePromocionsFormFilter extends BaseFormFilterPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'Nom'        => new sfWidgetFormFilterInput(),
      'Ordre'      => new sfWidgetFormFilterInput(),
      'Extensio'   => new sfWidgetFormFilterInput(),
      'isActiva'   => new sfWidgetFormFilterInput(),
      'isFixa'     => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'URL'        => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'site_id'    => new sfWidgetFormFilterInput(),
    ));

    $this->setValidators(array(
      'Nom'        => new sfValidatorPass(array('required' => false)),
      'Ordre'      => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'Extensio'   => new sfValidatorPass(array('required' => false)),
      'isActiva'   => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'isFixa'     => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'URL'        => new sfValidatorPass(array('required' => false)),
      'site_id'    => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
    ));

    $this->widgetSchema->setNameFormat('promocions_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'Promocions';
  }

  public function getFields()
  {
    return array(
      'PromocioID' => 'Number',
      'Nom'        => 'Text',
      'Ordre'      => 'Number',
      'Extensio'   => 'Text',
      'isActiva'   => 'Number',
      'isFixa'     => 'Number',
      'URL'        => 'Text',
      'site_id'    => 'Number',
    );
  }
}
