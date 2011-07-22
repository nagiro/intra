<?php

/**
 * MissatgesEmails filter form base class.
 *
 * @package    intranet
 * @subpackage filter
 * @author     Albert Johé i Martí
 */
abstract class BaseMissatgesEmailsFormFilter extends BaseFormFilterPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'site_id'  => new sfWidgetFormFilterInput(),
    ));

    $this->setValidators(array(
      'site_id'  => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
    ));

    $this->widgetSchema->setNameFormat('missatges_emails_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'MissatgesEmails';
  }

  public function getFields()
  {
    return array(
      'idLlista' => 'ForeignKey',
      'email'    => 'Text',
      'site_id'  => 'Number',
    );
  }
}
