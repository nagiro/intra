<?php

/**
 * Projectes form base class.
 *
 * @package    intranet
 * @subpackage form
 * @author     Albert Johé i Martí
 * @version    SVN: $Id: sfPropelFormGeneratedTemplate.php 16976 2009-04-04 12:47:44Z fabien $
 */
class BaseProjectesForm extends BaseFormPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'idProjectes'                         => new sfWidgetFormInputHidden(),
      'Entitats_EntitatID'                  => new sfWidgetFormPropelChoice(array('model' => 'Entitats', 'add_empty' => false)),
      'Nom'                                 => new sfWidgetFormTextarea(),
      'Descripcio'                          => new sfWidgetFormTextarea(),
      'Habilitat'                           => new sfWidgetFormInputText(),
      'projectes_has_agendaactivitats_list' => new sfWidgetFormPropelChoice(array('model' => 'Agendaactivitats', 'multiple'=>true)),
      'projectes_has_blogarticles_list'     => new sfWidgetFormPropelChoice(array('model' => 'Blogarticles', 'multiple'=>true)),
      'subcategories_has_projectes_list'    => new sfWidgetFormPropelChoice(array('model' => 'Subcategories', 'multiple'=>true)),
    ));

    $this->setValidators(array(
      'idProjectes'                         => new sfValidatorPropelChoice(array('model' => 'Projectes', 'column' => 'idProjectes', 'required' => false)),
      'Entitats_EntitatID'                  => new sfValidatorPropelChoice(array('model' => 'Entitats', 'column' => 'EntitatID')),
      'Nom'                                 => new sfValidatorString(),
      'Descripcio'                          => new sfValidatorString(),
      'Habilitat'                           => new sfValidatorInteger(),
      'projectes_has_agendaactivitats_list' => new sfValidatorPropelChoice(array('model' => 'Agendaactivitats', 'required' => false, 'multiple'=>true)),
      'projectes_has_blogarticles_list'     => new sfValidatorPropelChoice(array('model' => 'Blogarticles', 'required' => false, 'multiple'=>true)),
      'subcategories_has_projectes_list'    => new sfValidatorPropelChoice(array('model' => 'Subcategories', 'required' => false, 'multiple'=>true)),
    ));

    $this->widgetSchema->setNameFormat('projectes[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'Projectes';
  }


  public function updateDefaultsFromObject()
  {
    parent::updateDefaultsFromObject();

    if (isset($this->widgetSchema['projectes_has_agendaactivitats_list']))
    {
      $values = array();
      foreach ($this->object->getProjectesHasAgendaactivitatss() as $obj)
      {
        $values[] = $obj->getAgendaactivitatsAgendaactivitatsactivitatsid();
      }

      $this->setDefault('projectes_has_agendaactivitats_list', $values);
    }

    if (isset($this->widgetSchema['projectes_has_blogarticles_list']))
    {
      $values = array();
      foreach ($this->object->getProjectesHasBlogarticless() as $obj)
      {
        $values[] = $obj->getBlogarticlesArticlesid();
      }

      $this->setDefault('projectes_has_blogarticles_list', $values);
    }

    if (isset($this->widgetSchema['subcategories_has_projectes_list']))
    {
      $values = array();
      foreach ($this->object->getSubcategoriesHasProjectess() as $obj)
      {
        $values[] = $obj->getSubcategoriesIdsubcategories();
      }

      $this->setDefault('subcategories_has_projectes_list', $values);
    }

  }

  protected function doSave($con = null)
  {
    parent::doSave($con);

    $this->saveProjectesHasAgendaactivitatsList($con);
    $this->saveProjectesHasBlogarticlesList($con);
    $this->saveSubcategoriesHasProjectesList($con);
  }

  public function saveProjectesHasAgendaactivitatsList($con = null)
  {
    if (!$this->isValid())
    {
      throw $this->getErrorSchema();
    }

    if (!isset($this->widgetSchema['projectes_has_agendaactivitats_list']))
    {
      // somebody has unset this widget
      return;
    }

    if (is_null($con))
    {
      $con = $this->getConnection();
    }

    $c = new Criteria();
    $c->add(ProjectesHasAgendaactivitatsPeer::PROJECTES_IDPROJECTES, $this->object->getPrimaryKey());
    ProjectesHasAgendaactivitatsPeer::doDelete($c, $con);

    $values = $this->getValue('projectes_has_agendaactivitats_list');
    if (is_array($values))
    {
      foreach ($values as $value)
      {
        $obj = new ProjectesHasAgendaactivitats();
        $obj->setProjectesIdprojectes($this->object->getPrimaryKey());
        $obj->setAgendaactivitatsAgendaactivitatsactivitatsid($value);
        $obj->save();
      }
    }
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
    $c->add(ProjectesHasBlogarticlesPeer::PROJECTES_IDPROJECTES, $this->object->getPrimaryKey());
    ProjectesHasBlogarticlesPeer::doDelete($c, $con);

    $values = $this->getValue('projectes_has_blogarticles_list');
    if (is_array($values))
    {
      foreach ($values as $value)
      {
        $obj = new ProjectesHasBlogarticles();
        $obj->setProjectesIdprojectes($this->object->getPrimaryKey());
        $obj->setBlogarticlesArticlesid($value);
        $obj->save();
      }
    }
  }

  public function saveSubcategoriesHasProjectesList($con = null)
  {
    if (!$this->isValid())
    {
      throw $this->getErrorSchema();
    }

    if (!isset($this->widgetSchema['subcategories_has_projectes_list']))
    {
      // somebody has unset this widget
      return;
    }

    if (is_null($con))
    {
      $con = $this->getConnection();
    }

    $c = new Criteria();
    $c->add(SubcategoriesHasProjectesPeer::PROJECTES_IDPROJECTES, $this->object->getPrimaryKey());
    SubcategoriesHasProjectesPeer::doDelete($c, $con);

    $values = $this->getValue('subcategories_has_projectes_list');
    if (is_array($values))
    {
      foreach ($values as $value)
      {
        $obj = new SubcategoriesHasProjectes();
        $obj->setProjectesIdprojectes($this->object->getPrimaryKey());
        $obj->setSubcategoriesIdsubcategories($value);
        $obj->save();
      }
    }
  }

}
