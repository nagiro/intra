<?php

/**
 * Blogarticles form base class.
 *
 * @package    intranet
 * @subpackage form
 * @author     Albert Johé i Martí
 * @version    SVN: $Id: sfPropelFormGeneratedTemplate.php 16976 2009-04-04 12:47:44Z fabien $
 */
class BaseBlogarticlesForm extends BaseFormPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'ArticlesID'                      => new sfWidgetFormInputHidden(),
      'Cluber_idClubber'                => new sfWidgetFormPropelChoice(array('model' => 'Cluber', 'add_empty' => false)),
      'Titol'                           => new sfWidgetFormTextarea(),
      'Text'                            => new sfWidgetFormTextarea(),
      'Date'                            => new sfWidgetFormDate(),
      'Hora'                            => new sfWidgetFormTime(),
      'projectes_has_blogarticles_list' => new sfWidgetFormPropelChoice(array('model' => 'Projectes', 'multiple'=>true)),
    ));

    $this->setValidators(array(
      'ArticlesID'                      => new sfValidatorPropelChoice(array('model' => 'Blogarticles', 'column' => 'ArticlesID', 'required' => false)),
      'Cluber_idClubber'                => new sfValidatorPropelChoice(array('model' => 'Cluber', 'column' => 'idClubber')),
      'Titol'                           => new sfValidatorString(array('required' => false)),
      'Text'                            => new sfValidatorString(array('required' => false)),
      'Date'                            => new sfValidatorDate(array('required' => false)),
      'Hora'                            => new sfValidatorTime(array('required' => false)),
      'projectes_has_blogarticles_list' => new sfValidatorPropelChoice(array('model' => 'Projectes', 'required' => false, 'multiple'=>true)),
    ));

    $this->widgetSchema->setNameFormat('blogarticles[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'Blogarticles';
  }


  public function updateDefaultsFromObject()
  {
    parent::updateDefaultsFromObject();

    if (isset($this->widgetSchema['projectes_has_blogarticles_list']))
    {
      $values = array();
      foreach ($this->object->getProjectesHasBlogarticless() as $obj)
      {
        $values[] = $obj->getProjectesIdprojectes();
      }

      $this->setDefault('projectes_has_blogarticles_list', $values);
    }

  }

  protected function doSave($con = null)
  {
    parent::doSave($con);

    $this->saveProjectesHasBlogarticlesList($con);
  }

  public function saveProjectesHasBlogarticlesList($con = null)
  {
    if (!$this->isValid())
    {
      throw $this->getErrorSchema();
    }

    if (!isset($this->widgetSchema['projectes_has_blogarticles_list']))
    {
      // somebody has unset this widget
      return;
    }

    if (is_null($con))
    {
      $con = $this->getConnection();
    }

    $c = new Criteria();
    $c->add(ProjectesHasBlogarticlesPeer::BLOGARTICLES_ARTICLESID, $this->object->getPrimaryKey());
    ProjectesHasBlogarticlesPeer::doDelete($c, $con);

    $values = $this->getValue('projectes_has_blogarticles_list');
    if (is_array($values))
    {
      foreach ($values as $value)
      {
        $obj = new ProjectesHasBlogarticles();
        $obj->setBlogarticlesArticlesid($this->object->getPrimaryKey());
        $obj->setProjectesIdprojectes($value);
        $obj->save();
      }
    }
  }

}
