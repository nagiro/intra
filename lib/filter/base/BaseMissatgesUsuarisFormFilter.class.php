<?php

/**
 * MissatgesUsuaris filter form base class.
 *
 * @package    intranet
 * @subpackage filter
 * @author     Albert Johé i Martí
 */
abstract class BaseMissatgesUsuarisFormFilter extends BaseFormFilterPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'data'     => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate())),
      'site_id'  => new sfWidgetFormFilterInput(),
    ));

    $this->setValidators(array(
      'data'     => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDate(array('required' => false)), 'to_date' => new sfValidatorDate(array('required' => false)))),
      'site_id'  => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
    ));

    $this->widgetSchema->setNameFormat('missatges_usuaris_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'MissatgesUsuaris';
  }

  public function getFields()
  {
    return array(
      'idLlista' => 'ForeignKey',
      'email'    => 'Text',
      'data'     => 'Date',
      'site_id'  => 'Number',
    );
  }
}
