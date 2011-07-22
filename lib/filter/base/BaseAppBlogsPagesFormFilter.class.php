<?php

/**
 * AppBlogsPages filter form base class.
 *
 * @package    intranet
 * @subpackage filter
 * @author     Albert Johé i Martí
 */
abstract class BaseAppBlogsPagesFormFilter extends BaseFormFilterPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'name'    => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'visible' => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'date'    => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate(), 'with_empty' => false)),
      'type'    => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'blog_id' => new sfWidgetFormPropelChoice(array('model' => 'AppBlogsBlogs', 'add_empty' => true)),
      'site_id' => new sfWidgetFormFilterInput(),
    ));

    $this->setValidators(array(
      'name'    => new sfValidatorPass(array('required' => false)),
      'visible' => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'date'    => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDate(array('required' => false)), 'to_date' => new sfValidatorDate(array('required' => false)))),
      'type'    => new sfValidatorPass(array('required' => false)),
      'blog_id' => new sfValidatorPropelChoice(array('required' => false, 'model' => 'AppBlogsBlogs', 'column' => 'id')),
      'site_id' => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
    ));

    $this->widgetSchema->setNameFormat('app_blogs_pages_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'AppBlogsPages';
  }

  public function getFields()
  {
    return array(
      'id'      => 'Number',
      'name'    => 'Text',
      'visible' => 'Number',
      'date'    => 'Date',
      'type'    => 'Text',
      'blog_id' => 'ForeignKey',
      'site_id' => 'Number',
    );
  }
}
