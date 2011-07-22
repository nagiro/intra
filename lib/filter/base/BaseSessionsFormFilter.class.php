<?php

/**
 * Sessions filter form base class.
 *
 * @package    intranet
 * @subpackage filter
 * @author     Albert Johé i Martí
 */
abstract class BaseSessionsFormFilter extends BaseFormFilterPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'sess_id'   => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'sess_data' => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'sess_time' => new sfWidgetFormFilterInput(array('with_empty' => false)),
    ));

    $this->setValidators(array(
      'sess_id'   => new sfValidatorPass(array('required' => false)),
      'sess_data' => new sfValidatorPass(array('required' => false)),
      'sess_time' => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
    ));

    $this->widgetSchema->setNameFormat('sessions_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'Sessions';
  }

  public function getFields()
  {
    return array(
      'sess_id'   => 'Text',
      'sess_data' => 'Text',
      'sess_time' => 'Number',
      'id'        => 'Number',
    );
  }
}
