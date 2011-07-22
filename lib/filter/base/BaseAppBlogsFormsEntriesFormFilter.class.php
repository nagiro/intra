<?php

/**
 * AppBlogsFormsEntries filter form base class.
 *
 * @package    intranet
 * @subpackage filter
 * @author     Albert Johé i Martí
 */
abstract class BaseAppBlogsFormsEntriesFormFilter extends BaseFormFilterPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'dades'      => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'date'       => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate(), 'with_empty' => false)),
      'form_id'    => new sfWidgetFormPropelChoice(array('model' => 'AppBlogsForms', 'add_empty' => true)),
      'estat'      => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'objeccions' => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'site_id'    => new sfWidgetFormFilterInput(),
    ));

    $this->setValidators(array(
      'dades'      => new sfValidatorPass(array('required' => false)),
      'date'       => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDate(array('required' => false)), 'to_date' => new sfValidatorDate(array('required' => false)))),
      'form_id'    => new sfValidatorPropelChoice(array('required' => false, 'model' => 'AppBlogsForms', 'column' => 'id')),
      'estat'      => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'objeccions' => new sfValidatorPass(array('required' => false)),
      'site_id'    => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
    ));

    $this->widgetSchema->setNameFormat('app_blogs_forms_entries_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'AppBlogsFormsEntries';
  }

  public function getFields()
  {
    return array(
      'id'         => 'Number',
      'dades'      => 'Text',
      'date'       => 'Date',
      'form_id'    => 'ForeignKey',
      'estat'      => 'Number',
      'objeccions' => 'Text',
      'site_id'    => 'Number',
    );
  }
}
