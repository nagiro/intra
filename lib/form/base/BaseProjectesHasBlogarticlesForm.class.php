<?php

/**
 * ProjectesHasBlogarticles form base class.
 *
 * @package    intranet
 * @subpackage form
 * @author     Albert Johé i Martí
 * @version    SVN: $Id: sfPropelFormGeneratedTemplate.php 16976 2009-04-04 12:47:44Z fabien $
 */
class BaseProjectesHasBlogarticlesForm extends BaseFormPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'Projectes_idProjectes'   => new sfWidgetFormInputHidden(),
      'BlogArticles_ArticlesID' => new sfWidgetFormInputHidden(),
    ));

    $this->setValidators(array(
      'Projectes_idProjectes'   => new sfValidatorPropelChoice(array('model' => 'Projectes', 'column' => 'idProjectes', 'required' => false)),
      'BlogArticles_ArticlesID' => new sfValidatorPropelChoice(array('model' => 'Blogarticles', 'column' => 'ArticlesID', 'required' => false)),
    ));

    $this->widgetSchema->setNameFormat('projectes_has_blogarticles[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'ProjectesHasBlogarticles';
  }


}
