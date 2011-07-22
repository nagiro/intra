<?php

/**
 * AppBlogsForms form base class.
 *
 * @method AppBlogsForms getObject() Returns the current form's model object
 *
 * @package    intranet
 * @subpackage form
 * @author     Your name here
 */
abstract class BaseAppBlogsFormsForm extends BaseFormPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'          => new sfWidgetFormInputHidden(),
      'name'        => new sfWidgetFormInputText(),
      'blog_id'     => new sfWidgetFormPropelChoice(array('model' => 'AppBlogsBlogs', 'add_empty' => false)),
      'view_fields' => new sfWidgetFormTextarea(),
      'site_id'     => new sfWidgetFormInputText(),
      'actiu'       => new sfWidgetFormInputText(),
    ));

    $this->setValidators(array(
      'id'          => new sfValidatorChoice(array('choices' => array($this->getObject()->getId()), 'empty_value' => $this->getObject()->getId(), 'required' => false)),
      'name'        => new sfValidatorString(array('max_length' => 30)),
      'blog_id'     => new sfValidatorPropelChoice(array('model' => 'AppBlogsBlogs', 'column' => 'id')),
      'view_fields' => new sfValidatorString(),
      'site_id'     => new sfValidatorInteger(array('min' => -128, 'max' => 127, 'required' => false)),
      'actiu'       => new sfValidatorInteger(array('min' => -128, 'max' => 127)),
    ));

    $this->widgetSchema->setNameFormat('app_blogs_forms[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'AppBlogsForms';
  }


}
