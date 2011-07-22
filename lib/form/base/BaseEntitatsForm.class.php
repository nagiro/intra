<?php

/**
 * Entitats form base class.
 *
 * @package    intranet
 * @subpackage form
 * @author     Albert Johé i Martí
 * @version    SVN: $Id: sfPropelFormGeneratedTemplate.php 16976 2009-04-04 12:47:44Z fabien $
 */
class BaseEntitatsForm extends BaseFormPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'EntitatID'                       => new sfWidgetFormInputHidden(),
      'Nom'                             => new sfWidgetFormTextarea(),
      'Descripcio'                      => new sfWidgetFormTextarea(),
      'Habilitat'                       => new sfWidgetFormInputText(),
      'subcategories_has_entitats_list' => new sfWidgetFormPropelChoice(array('model' => 'Subcategories', 'multiple'=>true)),
    ));

    $this->setValidators(array(
      'EntitatID'                       => new sfValidatorPropelChoice(array('model' => 'Entitats', 'column' => 'EntitatID', 'required' => false)),
      'Nom'                             => new sfValidatorString(array('required' => false)),
      'Descripcio'                      => new sfValidatorString(array('required' => false)),
      'Habilitat'                       => new sfValidatorInteger(array('required' => false)),
      'subcategories_has_entitats_list' => new sfValidatorPropelChoice(array('model' => 'Subcategories', 'required' => false, 'multiple'=>true)),
    ));

    $this->widgetSchema->setNameFormat('entitats[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'Entitats';
  }


  public function updateDefaultsFromObject()
  {
    parent::updateDefaultsFromObject();

    if (isset($this->widgetSchema['subcategories_has_entitats_list']))
    {
      $values = array();
      foreach ($this->object->getSubcategoriesHasEntitatss() as $obj)
      {
        $values[] = $obj->getSubcategoriesIdsubcategories();
      }

      $this->setDefault('subcategories_has_entitats_list', $values);
    }

  }

  protected function doSave($con = null)
  {
    parent::doSave($con);

    $this->saveSubcategoriesHasEntitatsList($con);
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
    $c->add(SubcategoriesHasEntitatsPeer::ENTITATS_ENTITATID, $this->object->getPrimaryKey());
    SubcategoriesHasEntitatsPeer::doDelete($c, $con);

    $values = $this->getValue('subcategories_has_entitats_list');
    if (is_array($values))
    {
      foreach ($values as $value)
      {
        $obj = new SubcategoriesHasEntitats();
        $obj->setEntitatsEntitatid($this->object->getPrimaryKey());
        $obj->setSubcategoriesIdsubcategories($value);
        $obj->save();
      }
    }
  }

}
