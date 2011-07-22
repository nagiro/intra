<?php

/**
 * AppBlogsPages form base class.
 *
 * @method AppBlogsPages getObject() Returns the current form's model object
 *
 * @package    intranet
 * @subpackage form
 * @author     Your name here
 */
abstract class BaseAppBlogsPagesForm extends BaseFormPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'      => new sfWidgetFormInputHidden(),
      'name'    => new sfWidgetFormInputText(),
      'visible' => new sfWidgetFormInputText(),
      'date'    => new sfWidgetFormDate(),
      'type'    => new sfWidgetFormInputText(),
      'blog_id' => new sfWidgetFormPropelChoice(array('model' => 'AppBlogsBlogs', 'add_empty' => false)),
      'site_id' => new sfWidgetFormInputText(),
      'actiu'   => new sfWidgetFormInputText(),
    ));

    $this->setValidators(array(
      'id'      => new sfValidatorChoice(array('choices' => array($this->getObject()->getId()), 'empty_value' => $this->getObject()->getId(), 'required' => false)),
      'name'    => new sfValidatorString(array('max_length' => 40)),
      'visible' => new sfValidatorInteger(array('min' => -128, 'max' => 127)),
      'date'    => new sfValidatorDate(),
      'type'    => new sfValidatorString(array('max_length' => 1)),
      'blog_id' => new sfValidatorPropelChoice(array('model' => 'AppBlogsBlogs', 'column' => 'id')),
      'site_id' => new sfValidatorInteger(array('min' => -128, 'max' => 127, 'required' => false)),
      'actiu'   => new sfValidatorInteger(array('min' => -128, 'max' => 127)),
    ));

    $this->widgetSchema->setNameFormat('app_blogs_pages[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'AppBlogsPages';
  }


}
