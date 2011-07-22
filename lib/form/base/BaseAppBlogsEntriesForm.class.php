<?php

/**
 * AppBlogsEntries form base class.
 *
 * @method AppBlogsEntries getObject() Returns the current form's model object
 *
 * @package    intranet
 * @subpackage form
 * @author     Your name here
 */
abstract class BaseAppBlogsEntriesForm extends BaseFormPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'                               => new sfWidgetFormInputHidden(),
      'page_id'                          => new sfWidgetFormPropelChoice(array('model' => 'AppBlogsPages', 'add_empty' => false)),
      'lang'                             => new sfWidgetFormInputText(),
      'title'                            => new sfWidgetFormInputText(),
      'subtitle1'                        => new sfWidgetFormInputText(),
      'subtitle2'                        => new sfWidgetFormInputText(),
      'body'                             => new sfWidgetFormTextarea(),
      'date'                             => new sfWidgetFormDateTime(),
      'tags'                             => new sfWidgetFormInputText(),
      'url'                              => new sfWidgetFormTextarea(),
      'site_id'                          => new sfWidgetFormInputText(),
      'actiu'                            => new sfWidgetFormInputText(),
      'app_blog_multimedia_entries_list' => new sfWidgetFormPropelChoice(array('multiple' => true, 'model' => 'AppBlogsMultimedia')),
    ));

    $this->setValidators(array(
      'id'                               => new sfValidatorChoice(array('choices' => array($this->getObject()->getId()), 'empty_value' => $this->getObject()->getId(), 'required' => false)),
      'page_id'                          => new sfValidatorPropelChoice(array('model' => 'AppBlogsPages', 'column' => 'id')),
      'lang'                             => new sfValidatorString(array('max_length' => 4)),
      'title'                            => new sfValidatorString(array('max_length' => 255)),
      'subtitle1'                        => new sfValidatorString(array('max_length' => 100)),
      'subtitle2'                        => new sfValidatorString(array('max_length' => 100)),
      'body'                             => new sfValidatorString(),
      'date'                             => new sfValidatorDateTime(),
      'tags'                             => new sfValidatorString(array('max_length' => 150)),
      'url'                              => new sfValidatorString(),
      'site_id'                          => new sfValidatorInteger(array('min' => -128, 'max' => 127, 'required' => false)),
      'actiu'                            => new sfValidatorInteger(array('min' => -128, 'max' => 127)),
      'app_blog_multimedia_entries_list' => new sfValidatorPropelChoice(array('multiple' => true, 'model' => 'AppBlogsMultimedia', 'required' => false)),
    ));

    $this->widgetSchema->setNameFormat('app_blogs_entries[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'AppBlogsEntries';
  }


  public function updateDefaultsFromObject()
  {
    parent::updateDefaultsFromObject();

    if (isset($this->widgetSchema['app_blog_multimedia_entries_list']))
    {
      $values = array();
      foreach ($this->object->getAppBlogMultimediaEntriess() as $obj)
      {
        $values[] = $obj->getMultimediaId();
      }

      $this->setDefault('app_blog_multimedia_entries_list', $values);
    }

  }

  protected function doSave($con = null)
  {
    parent::doSave($con);

    $this->saveAppBlogMultimediaEntriesList($con);
  }

  public function saveAppBlogMultimediaEntriesList($con = null)
  {
    if (!$this->isValid())
    {
      throw $this->getErrorSchema();
    }

    if (!isset($this->widgetSchema['app_blog_multimedia_entries_list']))
    {
      // somebody has unset this widget
      return;
    }

    if (null === $con)
    {
      $con = $this->getConnection();
    }

    $c = new Criteria();
    $c->add(AppBlogMultimediaEntriesPeer::ENTRIES_ID, $this->object->getPrimaryKey());
    AppBlogMultimediaEntriesPeer::doDelete($c, $con);

    $values = $this->getValue('app_blog_multimedia_entries_list');
    if (is_array($values))
    {
      foreach ($values as $value)
      {
        $obj = new AppBlogMultimediaEntries();
        $obj->setEntriesId($this->object->getPrimaryKey());
        $obj->setMultimediaId($value);
        $obj->save();
      }
    }
  }

}
