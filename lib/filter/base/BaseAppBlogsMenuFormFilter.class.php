<?php

/**
 * AppBlogsMenu filter form base class.
 *
 * @package    intranet
 * @subpackage filter
 * @author     Albert Johé i Martí
 */
abstract class BaseAppBlogsMenuFormFilter extends BaseFormFilterPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'name'      => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'page_id'   => new sfWidgetFormPropelChoice(array('model' => 'AppBlogsPages', 'add_empty' => true)),
      'order'     => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'blog_id'   => new sfWidgetFormPropelChoice(array('model' => 'AppBlogsBlogs', 'add_empty' => true)),
      'father_id' => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'site_id'   => new sfWidgetFormFilterInput(),
    ));

    $this->setValidators(array(
      'name'      => new sfValidatorPass(array('required' => false)),
      'page_id'   => new sfValidatorPropelChoice(array('required' => false, 'model' => 'AppBlogsPages', 'column' => 'id')),
      'order'     => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'blog_id'   => new sfValidatorPropelChoice(array('required' => false, 'model' => 'AppBlogsBlogs', 'column' => 'id')),
      'father_id' => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'site_id'   => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
    ));

    $this->widgetSchema->setNameFormat('app_blogs_menu_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'AppBlogsMenu';
  }

  public function getFields()
  {
    return array(
      'id'        => 'Number',
      'name'      => 'Text',
      'page_id'   => 'ForeignKey',
      'order'     => 'Number',
      'blog_id'   => 'ForeignKey',
      'father_id' => 'Number',
      'site_id'   => 'Number',
    );
  }
}
