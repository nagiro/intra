<?php

/**
 * HospiciArticlesComentaris form base class.
 *
 * @method HospiciArticlesComentaris getObject() Returns the current form's model object
 *
 * @package    intranet
 * @subpackage form
 * @author     Your name here
 */
abstract class BaseHospiciArticlesComentarisForm extends BaseFormPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'comentari_id' => new sfWidgetFormInputHidden(),
      'article_id'   => new sfWidgetFormInputText(),
      'qui'          => new sfWidgetFormTextarea(),
      'comentari'    => new sfWidgetFormTextarea(),
    ));

    $this->setValidators(array(
      'comentari_id' => new sfValidatorChoice(array('choices' => array($this->getObject()->getComentariId()), 'empty_value' => $this->getObject()->getComentariId(), 'required' => false)),
      'article_id'   => new sfValidatorInteger(array('min' => -2147483648, 'max' => 2147483647)),
      'qui'          => new sfValidatorString(),
      'comentari'    => new sfValidatorString(),
    ));

    $this->widgetSchema->setNameFormat('hospici_articles_comentaris[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'HospiciArticlesComentaris';
  }


}
