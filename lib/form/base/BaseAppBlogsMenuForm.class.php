<?php

/**
 * AppBlogsMenu form base class.
 *
 * @method AppBlogsMenu getObject() Returns the current form's model object
 *
 * @package    intranet
 * @subpackage form
 * @author     Your name here
 */
abstract class BaseAppBlogsMenuForm extends BaseFormPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'        => new sfWidgetFormInputHidden(),
      'name'      => new sfWidgetFormInputText(),
      'page_id'   => new sfWidgetFormPropelChoice(array('model' => 'AppBlogsPages', 'add_empty' => true)),
      'order'     => new sfWidgetFormInputText(),
      'blog_id'   => new sfWidgetFormPropelChoice(array('model' => 'AppBlogsBlogs', 'add_empty' => false)),
      'father_id' => new sfWidgetFormInputText(),
      'site_id'   => new sfWidgetFormInputText(),
      'actiu'     => new sfWidgetFormInputText(),
    ));

    $this->setValidators(array(
      'id'        => new sfValidatorChoice(array('choices' => array($this->getObject()->getId()), 'empty_value' => $this->getObject()->getId(), 'required' => false)),
      'name'      => new sfValidatorString(array('max_length' => 50)),
      'page_id'   => new sfValidatorPropelChoice(array('model' => 'AppBlogsPages', 'column' => 'id', 'required' => false)),
      'order'     => new sfValidatorInteger(array('min' => -2147483648, 'max' => 2147483647)),
      'blog_id'   => new sfValidatorPropelChoice(array('model' => 'AppBlogsBlogs', 'column' => 'id')),
      'father_id' => new sfValidatorInteger(array('min' => -2147483648, 'max' => 2147483647)),
      'site_id'   => new sfValidatorInteger(array('min' => -128, 'max' => 127, 'required' => false)),
      'actiu'     => new sfValidatorInteger(array('min' => -128, 'max' => 127)),
    ));

    $this->widgetSchema->setNameFormat('app_blogs_menu[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'AppBlogsMenu';
  }


}
