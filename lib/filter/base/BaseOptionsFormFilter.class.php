<?php

/**
 * Options filter form base class.
 *
 * @package    intranet
 * @subpackage filter
 * @author     Albert Johé i Martí
 */
abstract class BaseOptionsFormFilter extends BaseFormFilterPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'valor'     => new sfWidgetFormFilterInput(array('with_empty' => false)),
    ));

    $this->setValidators(array(
      'valor'     => new sfValidatorPass(array('required' => false)),
    ));

    $this->widgetSchema->setNameFormat('options_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'Options';
  }

  public function getFields()
  {
    return array(
      'option_id' => 'Text',
      'site_id'   => 'Number',
      'valor'     => 'Text',
    );
  }
}
