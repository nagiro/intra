<?php

/**
 * ArxiuDvd filter form base class.
 *
 * @package    intranet
 * @subpackage filter
 * @author     Albert Johé i Martí
 */
abstract class BaseArxiuDvdFormFilter extends BaseFormFilterPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'tipus'        => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'volum'        => new sfWidgetFormFilterInput(),
      'url'          => new sfWidgetFormFilterInput(),
      'nom'          => new sfWidgetFormFilterInput(),
      'data_creacio' => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate())),
      'comentari'    => new sfWidgetFormFilterInput(),
      'site_id'      => new sfWidgetFormFilterInput(),
    ));

    $this->setValidators(array(
      'tipus'        => new sfValidatorPass(array('required' => false)),
      'volum'        => new sfValidatorPass(array('required' => false)),
      'url'          => new sfValidatorPass(array('required' => false)),
      'nom'          => new sfValidatorPass(array('required' => false)),
      'data_creacio' => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDate(array('required' => false)), 'to_date' => new sfValidatorDate(array('required' => false)))),
      'comentari'    => new sfValidatorPass(array('required' => false)),
      'site_id'      => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
    ));

    $this->widgetSchema->setNameFormat('arxiu_dvd_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'ArxiuDvd';
  }

  public function getFields()
  {
    return array(
      'id'           => 'Number',
      'tipus'        => 'Text',
      'volum'        => 'Text',
      'url'          => 'Text',
      'nom'          => 'Text',
      'data_creacio' => 'Date',
      'comentari'    => 'Text',
      'site_id'      => 'Number',
    );
  }
}
