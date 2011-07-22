<?php

/**
 * AppBlogsFormsEntries form base class.
 *
 * @method AppBlogsFormsEntries getObject() Returns the current form's model object
 *
 * @package    intranet
 * @subpackage form
 * @author     Your name here
 */
abstract class BaseAppBlogsFormsEntriesForm extends BaseFormPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'         => new sfWidgetFormInputHidden(),
      'dades'      => new sfWidgetFormTextarea(),
      'date'       => new sfWidgetFormDateTime(),
      'form_id'    => new sfWidgetFormPropelChoice(array('model' => 'AppBlogsForms', 'add_empty' => false)),
      'estat'      => new sfWidgetFormInputText(),
      'objeccions' => new sfWidgetFormTextarea(),
      'site_id'    => new sfWidgetFormInputText(),
      'actiu'      => new sfWidgetFormInputText(),
    ));

    $this->setValidators(array(
      'id'         => new sfValidatorChoice(array('choices' => array($this->getObject()->getId()), 'empty_value' => $this->getObject()->getId(), 'required' => false)),
      'dades'      => new sfValidatorString(),
      'date'       => new sfValidatorDateTime(),
      'form_id'    => new sfValidatorPropelChoice(array('model' => 'AppBlogsForms', 'column' => 'id')),
      'estat'      => new sfValidatorInteger(array('min' => -128, 'max' => 127)),
      'objeccions' => new sfValidatorString(),
      'site_id'    => new sfValidatorInteger(array('min' => -128, 'max' => 127, 'required' => false)),
      'actiu'      => new sfValidatorInteger(array('min' => -128, 'max' => 127)),
    ));

    $this->widgetSchema->setNameFormat('app_blogs_forms_entries[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'AppBlogsFormsEntries';
  }


}
