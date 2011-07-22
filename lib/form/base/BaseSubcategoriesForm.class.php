<?php

/**
 * Subcategories form base class.
 *
 * @package    intranet
 * @subpackage form
 * @author     Albert Johé i Martí
 * @version    SVN: $Id: sfPropelFormGeneratedTemplate.php 16976 2009-04-04 12:47:44Z fabien $
 */
class BaseSubcategoriesForm extends BaseFormPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'idSubcategories'                  => new sfWidgetFormInputHidden(),
      'Categories_idCategories'          => new sfWidgetFormPropelChoice(array('model' => 'Categories', 'add_empty' => false)),
      'Subcategoria'                     => new sfWidgetFormTextarea(),
      'subcategories_has_entitats_list'  => new sfWidgetFormPropelChoice(array('model' => 'Entitats', 'multiple'=>true)),
      'subcategories_has_fitxers_list'   => new sfWidgetFormPropelChoice(array('model' => 'Fitxers', 'multiple'=>true)),
      'subcategories_has_projectes_list' => new sfWidgetFormPropelChoice(array('model' => 'Projectes', 'multiple'=>true)),
    ));

    $this->setValidators(array(
      'idSubcategories'                  => new sfValidatorPropelChoice(array('model' => 'Subcategories', 'column' => 'idSubcategories', 'required' => false)),
      'Categories_idCategories'          => new sfValidatorPropelChoice(array('model' => 'Categories', 'column' => 'idCategories')),
      'Subcategoria'                     => new sfValidatorString(array('required' => false)),
      'subcategories_has_entitats_list'  => new sfValidatorPropelChoice(array('model' => 'Entitats', 'required' => false, 'multiple'=>true)),
      'subcategories_has_fitxers_list'   => new sfValidatorPropelChoice(array('model' => 'Fitxers', 'required' => false, 'multiple'=>true)),
      'subcategories_has_projectes_list' => new sfValidatorPropelChoice(array('model' => 'Projectes', 'required' => false, 'multiple'=>true)),
    ));

    $this->widgetSchema->setNameFormat('subcategories[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'Subcategories';
  }


  public function updateDefaultsFromObject()
  {
    parent::updateDefaultsFromObject();

    if (isset($this->widgetSchema['subcategories_has_entitats_list']))
    {
      $values = array();
      foreach ($this->object->getSubcategoriesHasEntitatss() as $obj)
      {
        $values[] = $obj->getEntitatsEntitatid();
      }

      $this->setDefault('subcategories_has_entitats_list', $values);
    }

    if (isset($this->widgetSchema['subcategories_has_fitxers_list']))
    {
      $values = array();
      foreach ($this->object->getSubcategoriesHasFitxerss() as $obj)
      {
        $values[] = $obj->getFitxersFitxersid();
      }

      $this->setDefault('subcategories_has_fitxers_list', $values);
    }

    if (isset($this->widgetSchema['subcategories_has_projectes_list']))
    {
      $values = array();
      foreach ($this->object->getSubcategoriesHasProjectess() as $obj)
      {
        $values[] = $obj->getProjectesIdprojectes();
      }

      $this->setDefault('subcategories_has_projectes_list', $values);
    }

  }

  protected function doSave($con = null)
  {
    parent::doSave($con);

    $this->saveSubcategoriesHasEntitatsList($con);
    $this->saveSubcategoriesHasFitxersList($con);
    $this->saveSubcategoriesHasProjectesList($con);
  }

  public function saveSubcategoriesHasEntitatsList($con = null)
  {
    if (!$this->isValid())
    {
      throw $this->getErrorSchema();
    }

    if (!isset($this->widgetSchema['subcategories_has_entitats_list']))
    {
      // somebody has unset this widget
      return;
    }

    if (is_null($con))
    {
      $con = $this->getConnection();
    }

    $c = new Criteria();
    $c->add(SubcategoriesHasEntitatsPeer::SUBCATEGORIES_IDSUBCATEGORIES, $this->object->getPrimaryKey());
    SubcategoriesHasEntitatsPeer::doDelete($c, $con);

    $values = $this->getValue('subcategories_has_entitats_list');
    if (is_array($values))
    {
      foreach ($values as $value)
      {
        $obj = new SubcategoriesHasEntitats();
        $obj->setSubcategoriesIdsubcategories($this->object->getPrimaryKey());
        $obj->setEntitatsEntitatid($value);
        $obj->save();
      }
    }
  }

  public function saveSubcategoriesHasFitxersList($con = null)
  {
    if (!$this->isValid())
    {
      throw $this->getErrorSchema();
    }

    if (!isset($this->widgetSchema['subcategories_has_fitxers_list']))
    {
      // somebody has unset this widget
      return;
    }

    if (is_null($con))
    {
      $con = $this->getConnection();
    }

    $c = new Criteria();
    $c->add(SubcategoriesHasFitxersPeer::SUBCATEGORIES_IDSUBCATEGORIES, $this->object->getPrimaryKey());
    SubcategoriesHasFitxersPeer::doDelete($c, $con);

    $values = $this->getValue('subcategories_has_fitxers_list');
    if (is_array($values))
    {
      foreach ($values as $value)
      {
        $obj = new SubcategoriesHasFitxers();
        $obj->setSubcategoriesIdsubcategories($this->object->getPrimaryKey());
        $obj->setFitxersFitxersid($value);
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
    $c->add(SubcategoriesHasProjectesPeer::SUBCATEGORIES_IDSUBCATEGORIES, $this->object->getPrimaryKey());
    SubcategoriesHasProjectesPeer::doDelete($c, $con);

    $values = $this->getValue('subcategories_has_projectes_list');
    if (is_array($values))
    {
      foreach ($values as $value)
      {
        $obj = new SubcategoriesHasProjectes();
        $obj->setSubcategoriesIdsubcategories($this->object->getPrimaryKey());
        $obj->setProjectesIdprojectes($value);
        $obj->save();
      }
    }
  }

}
