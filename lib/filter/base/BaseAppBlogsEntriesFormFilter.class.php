<?php

/**
 * AppBlogsEntries filter form base class.
 *
 * @package    intranet
 * @subpackage filter
 * @author     Albert Johé i Martí
 */
abstract class BaseAppBlogsEntriesFormFilter extends BaseFormFilterPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'page_id'                          => new sfWidgetFormPropelChoice(array('model' => 'AppBlogsPages', 'add_empty' => true)),
      'lang'                             => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'title'                            => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'subtitle1'                        => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'subtitle2'                        => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'body'                             => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'date'                             => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate(), 'with_empty' => false)),
      'tags'                             => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'url'                              => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'site_id'                          => new sfWidgetFormFilterInput(),
      'app_blog_multimedia_entries_list' => new sfWidgetFormPropelChoice(array('model' => 'AppBlogsMultimedia', 'add_empty' => true)),
    ));

    $this->setValidators(array(
      'page_id'                          => new sfValidatorPropelChoice(array('required' => false, 'model' => 'AppBlogsPages', 'column' => 'id')),
      'lang'                             => new sfValidatorPass(array('required' => false)),
      'title'                            => new sfValidatorPass(array('required' => false)),
      'subtitle1'                        => new sfValidatorPass(array('required' => false)),
      'subtitle2'                        => new sfValidatorPass(array('required' => false)),
      'body'                             => new sfValidatorPass(array('required' => false)),
      'date'                             => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDate(array('required' => false)), 'to_date' => new sfValidatorDate(array('required' => false)))),
      'tags'                             => new sfValidatorPass(array('required' => false)),
      'url'                              => new sfValidatorPass(array('required' => false)),
      'site_id'                          => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'app_blog_multimedia_entries_list' => new sfValidatorPropelChoice(array('model' => 'AppBlogsMultimedia', 'required' => false)),
    ));

    $this->widgetSchema->setNameFormat('app_blogs_entries_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function addAppBlogMultimediaEntriesListColumnCriteria(Criteria $criteria, $field, $values)
  {
    if (!is_array($values))
    {
      $values = array($values);
    }

    if (!count($values))
    {
      return;
    }

    $criteria->addJoin(AppBlogMultimediaEntriesPeer::ENTRIES_ID, AppBlogsEntriesPeer::ID);

    $value = array_pop($values);
    $criterion = $criteria->getNewCriterion(AppBlogMultimediaEntriesPeer::MULTIMEDIA_ID, $value);

    foreach ($values as $value)
    {
      $criterion->addOr($criteria->getNewCriterion(AppBlogMultimediaEntriesPeer::MULTIMEDIA_ID, $value));
    }

    $criteria->add($criterion);
  }

  public function getModelName()
  {
    return 'AppBlogsEntries';
  }

  public function getFields()
  {
    return array(
      'id'                               => 'Number',
      'page_id'                          => 'ForeignKey',
      'lang'                             => 'Text',
      'title'                            => 'Text',
      'subtitle1'                        => 'Text',
      'subtitle2'                        => 'Text',
      'body'                             => 'Text',
      'date'                             => 'Date',
      'tags'                             => 'Text',
      'url'                              => 'Text',
      'site_id'                          => 'Number',
      'app_blog_multimedia_entries_list' => 'ManyKey',
    );
  }
}
