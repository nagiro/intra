<?php

/**
 * AppBlogsBlogs form base class.
 *
 * @method AppBlogsBlogs getObject() Returns the current form's model object
 *
 * @package    intranet
 * @subpackage form
 * @author     Your name here
 */
abstract class BaseAppBlogsBlogsForm extends BaseFormPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'      => new sfWidgetFormInputHidden(),
      'name'    => new sfWidgetFormInputText(),
      'date'    => new sfWidgetFormDate(),
      'site_id' => new sfWidgetFormInputText(),
      'actiu'   => new sfWidgetFormInputText(),
    ));

    $this->setValidators(array(
      'id'      => new sfValidatorChoice(array('choices' => array($this->getObject()->getId()), 'empty_value' => $this->getObject()->getId(), 'required' => false)),
      'name'    => new sfValidatorString(array('max_length' => 50)),
      'date'    => new sfValidatorDate(),
      'site_id' => new sfValidatorInteger(array('min' => -128, 'max' => 127, 'required' => false)),
      'actiu'   => new sfValidatorInteger(array('min' => -128, 'max' => 127)),
    ));

    $this->widgetSchema->setNameFormat('app_blogs_blogs[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'AppBlogsBlogs';
  }


}
