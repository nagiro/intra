<?php

/**
 * HospiciProjectesElements filter form base class.
 *
 * @package    intranet
 * @subpackage filter
 * @author     Albert Johé i Martí
 */
abstract class BaseHospiciProjectesElementsFormFilter extends BaseFormFilterPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'nivell'      => new sfWidgetFormFilterInput(),
    ));

    $this->setValidators(array(
      'nivell'      => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
    ));

    $this->widgetSchema->setNameFormat('hospici_projectes_elements_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'HospiciProjectesElements';
  }

  public function getFields()
  {
    return array(
      'element_id'  => 'Number',
      'tipus'       => 'Text',
      'projecte_id' => 'Number',
      'nivell'      => 'Number',
    );
  }
}
