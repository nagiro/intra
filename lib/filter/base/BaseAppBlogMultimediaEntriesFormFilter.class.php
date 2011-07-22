<?php

/**
 * AppBlogMultimediaEntries filter form base class.
 *
 * @package    intranet
 * @subpackage filter
 * @author     Albert Johé i Martí
 */
abstract class BaseAppBlogMultimediaEntriesFormFilter extends BaseFormFilterPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'site_id'       => new sfWidgetFormFilterInput(),
    ));

    $this->setValidators(array(
      'site_id'       => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
    ));

    $this->widgetSchema->setNameFormat('app_blog_multimedia_entries_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'AppBlogMultimediaEntries';
  }

  public function getFields()
  {
    return array(
      'entries_id'    => 'ForeignKey',
      'multimedia_id' => 'ForeignKey',
      'site_id'       => 'Number',
    );
  }
}
