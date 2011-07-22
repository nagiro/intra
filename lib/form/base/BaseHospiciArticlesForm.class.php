<?php

/**
 * HospiciArticles form base class.
 *
 * @method HospiciArticles getObject() Returns the current form's model object
 *
 * @package    intranet
 * @subpackage form
 * @author     Your name here
 */
abstract class BaseHospiciArticlesForm extends BaseFormPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'article_id' => new sfWidgetFormInputHidden(),
      'titol'      => new sfWidgetFormTextarea(),
      'text'       => new sfWidgetFormTextarea(),
      'data_alta'  => new sfWidgetFormDate(),
      'hora_alta'  => new sfWidgetFormTime(),
    ));

    $this->setValidators(array(
      'article_id' => new sfValidatorChoice(array('choices' => array($this->getObject()->getArticleId()), 'empty_value' => $this->getObject()->getArticleId(), 'required' => false)),
      'titol'      => new sfValidatorString(),
      'text'       => new sfValidatorString(),
      'data_alta'  => new sfValidatorDate(),
      'hora_alta'  => new sfValidatorTime(),
    ));

    $this->widgetSchema->setNameFormat('hospici_articles[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'HospiciArticles';
  }


}
