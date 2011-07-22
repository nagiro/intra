<?php

/**
 * GestioMenus form base class.
 *
 * @method GestioMenus getObject() Returns the current form's model object
 *
 * @package    intranet
 * @subpackage form
 * @author     Your name here
 */
abstract class BaseGestioMenusForm extends BaseFormPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'menu_id'            => new sfWidgetFormInputHidden(),
      'titol'              => new sfWidgetFormTextarea(),
      'url'                => new sfWidgetFormTextarea(),
      'categoria'          => new sfWidgetFormTextarea(),
      'ordre'              => new sfWidgetFormInputText(),
      'actiu'              => new sfWidgetFormInputText(),
      'tipus'              => new sfWidgetFormInputText(),
      'usuaris_menus_list' => new sfWidgetFormPropelChoice(array('multiple' => true, 'model' => 'Usuaris')),
    ));

    $this->setValidators(array(
      'menu_id'            => new sfValidatorChoice(array('choices' => array($this->getObject()->getMenuId()), 'empty_value' => $this->getObject()->getMenuId(), 'required' => false)),
      'titol'              => new sfValidatorString(),
      'url'                => new sfValidatorString(),
      'categoria'          => new sfValidatorString(),
      'ordre'              => new sfValidatorInteger(array('min' => -128, 'max' => 127)),
      'actiu'              => new sfValidatorInteger(array('min' => -128, 'max' => 127)),
      'tipus'              => new sfValidatorInteger(array('min' => -128, 'max' => 127)),
      'usuaris_menus_list' => new sfValidatorPropelChoice(array('multiple' => true, 'model' => 'Usuaris', 'required' => false)),
    ));

    $this->widgetSchema->setNameFormat('gestio_menus[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'GestioMenus';
  }


  public function updateDefaultsFromObject()
  {
    parent::updateDefaultsFromObject();

    if (isset($this->widgetSchema['usuaris_menus_list']))
    {
      $values = array();
      foreach ($this->object->getUsuarisMenuss() as $obj)
      {
        $values[] = $obj->getUsuariId();
      }

      $this->setDefault('usuaris_menus_list', $values);
    }

  }

  protected function doSave($con = null)
  {
    parent::doSave($con);

    $this->saveUsuarisMenusList($con);
  }

  public function saveUsuarisMenusList($con = null)
  {
    if (!$this->isValid())
    {
      throw $this->getErrorSchema();
    }

    if (!isset($this->widgetSchema['usuaris_menus_list']))
    {
      // somebody has unset this widget
      return;
    }

    if (null === $con)
    {
      $con = $this->getConnection();
    }

    $c = new Criteria();
    $c->add(UsuarisMenusPeer::MENU_ID, $this->object->getPrimaryKey());
    UsuarisMenusPeer::doDelete($c, $con);

    $values = $this->getValue('usuaris_menus_list');
    if (is_array($values))
    {
      foreach ($values as $value)
      {
        $obj = new UsuarisMenus();
        $obj->setMenuId($this->object->getPrimaryKey());
        $obj->setUsuariId($value);
        $obj->save();
      }
    }
  }

}
