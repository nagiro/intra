<?php

/**
 * HospiciArticlesComentaris filter form base class.
 *
 * @package    intranet
 * @subpackage filter
 * @author     Albert Johé i Martí
 */
abstract class BaseHospiciArticlesComentarisFormFilter extends BaseFormFilterPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'article_id'   => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'qui'          => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'comentari'    => new sfWidgetFormFilterInput(array('with_empty' => false)),
    ));

    $this->setValidators(array(
      'article_id'   => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'qui'          => new sfValidatorPass(array('required' => false)),
      'comentari'    => new sfValidatorPass(array('required' => false)),
    ));

    $this->widgetSchema->setNameFormat('hospici_articles_comentaris_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'HospiciArticlesComentaris';
  }

  public function getFields()
  {
    return array(
      'comentari_id' => 'Number',
      'article_id'   => 'Number',
      'qui'          => 'Text',
      'comentari'    => 'Text',
    );
  }
}
