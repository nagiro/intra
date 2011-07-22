<?php

/**
 * AppBlogMultimediaEntries form base class.
 *
 * @method AppBlogMultimediaEntries getObject() Returns the current form's model object
 *
 * @package    intranet
 * @subpackage form
 * @author     Your name here
 */
abstract class BaseAppBlogMultimediaEntriesForm extends BaseFormPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'entries_id'    => new sfWidgetFormInputHidden(),
      'multimedia_id' => new sfWidgetFormInputHidden(),
      'site_id'       => new sfWidgetFormInputText(),
      'actiu'         => new sfWidgetFormInputText(),
    ));

    $this->setValidators(array(
      'entries_id'    => new sfValidatorPropelChoice(array('model' => 'AppBlogsEntries', 'column' => 'id', 'required' => false)),
      'multimedia_id' => new sfValidatorPropelChoice(array('model' => 'AppBlogsMultimedia', 'column' => 'id', 'required' => false)),
      'site_id'       => new sfValidatorInteger(array('min' => -128, 'max' => 127, 'required' => false)),
      'actiu'         => new sfValidatorInteger(array('min' => -128, 'max' => 127)),
    ));

    $this->widgetSchema->setNameFormat('app_blog_multimedia_entries[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'AppBlogMultimediaEntries';
  }


}
