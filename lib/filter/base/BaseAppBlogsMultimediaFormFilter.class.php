<?php

/**
 * AppBlogsMultimedia filter form base class.
 *
 * @package    intranet
 * @subpackage filter
 * @author     Albert Johé i Martí
 */
abstract class BaseAppBlogsMultimediaFormFilter extends BaseFormFilterPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'name'                             => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'desc'                             => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'url'                              => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'date'                             => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate(), 'with_empty' => false)),
      'site_id'                          => new sfWidgetFormFilterInput(),
      'app_blog_multimedia_entries_list' => new sfWidgetFormPropelChoice(array('model' => 'AppBlogsEntries', 'add_empty' => true)),
    ));

    $this->setValidators(array(
      'name'                             => new sfValidatorPass(array('required' => false)),
      'desc'                             => new sfValidatorPass(array('required' => false)),
      'url'                              => new sfValidatorPass(array('required' => false)),
      'date'                             => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDate(array('required' => false)), 'to_date' => new sfValidatorDate(array('required' => false)))),
      'site_id'                          => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'app_blog_multimedia_entries_list' => new sfValidatorPropelChoice(array('model' => 'AppBlogsEntries', 'required' => false)),
    ));

    $this->widgetSchema->setNameFormat('app_blogs_multimedia_filters[%s]');

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

    $criteria->addJoin(AppBlogMultimediaEntriesPeer::MULTIMEDIA_ID, AppBlogsMultimediaPeer::ID);

    $value = array_pop($values);
    $criterion = $criteria->getNewCriterion(AppBlogMultimediaEntriesPeer::ENTRIES_ID, $value);

    foreach ($values as $value)
    {
      $criterion->addOr($criteria->getNewCriterion(AppBlogMultimediaEntriesPeer::ENTRIES_ID, $value));
    }

    $criteria->add($criterion);
  }

  public function getModelName()
  {
    return 'AppBlogsMultimedia';
  }

  public function getFields()
  {
    return array(
      'id'                               => 'Number',
      'name'                             => 'Text',
      'desc'                             => 'Text',
      'url'                              => 'Text',
      'date'                             => 'Date',
      'site_id'                          => 'Number',
      'app_blog_multimedia_entries_list' => 'ManyKey',
    );
  }
}
