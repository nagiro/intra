<?php

/**
 * Apps form base class.
 *
 * @method Apps getObject() Returns the current form's model object
 *
 * @package    intranet
 * @subpackage form
 * @author     Your name here
 */
abstract class BaseAppsForm extends BaseFormPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'app_id'            => new sfWidgetFormInputHidden(),
      'Nom'               => new sfWidgetFormTextarea(),
      'Url'               => new sfWidgetFormTextarea(),
      'site_id'           => new sfWidgetFormInputText(),
      'actiu'             => new sfWidgetFormInputText(),
      'usuaris_apps_list' => new sfWidgetFormPropelChoice(array('multiple' => true, 'model' => 'Usuaris')),
    ));

    $this->setValidators(array(
      'app_id'            => new sfValidatorChoice(array('choices' => array($this->getObject()->getAppId()), 'empty_value' => $this->getObject()->getAppId(), 'required' => false)),
      'Nom'               => new sfValidatorString(),
      'Url'               => new sfValidatorString(),
      'site_id'           => new sfValidatorInteger(array('min' => -128, 'max' => 127, 'required' => false)),
      'actiu'             => new sfValidatorInteger(array('min' => -128, 'max' => 127)),
      'usuaris_apps_list' => new sfValidatorPropelChoice(array('multiple' => true, 'model' => 'Usuaris', 'required' => false)),
    ));

    $this->widgetSchema->setNameFormat('apps[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'Apps';
  }


  public function updateDefaultsFromObject()
  {
    parent::updateDefaultsFromObject();

    if (isset($this->widgetSchema['usuaris_apps_list']))
    {
      $values = array();
      foreach ($this->object->getUsuarisAppss() as $obj)
      {
        $values[] = $obj->getUsuariId();
      }

      $this->setDefault('usuaris_apps_list', $values);
    }

  }

  protected function doSave($con = null)
  {
    parent::doSave($con);

    $this->saveUsuarisAppsList($con);
  }

  public function saveUsuarisAppsList($con = null)
  {
    if (!$this->isValid())
    {
      throw $this->getErrorSchema();
    }

    if (!isset($this->widgetSchema['usuaris_apps_list']))
    {
      // somebody has unset this widget
      return;
    }

    if (null === $con)
    {
      $con = $this->getConnection();
    }

    $c = new Criteria();
    $c->add(UsuarisAppsPeer::APP_ID, $this->object->getPrimaryKey());
    UsuarisAppsPeer::doDelete($c, $con);

    $values = $this->getValue('usuaris_apps_list');
    if (is_array($values))
    {
      foreach ($values as $value)
      {
        $obj = new UsuarisApps();
        $obj->setAppId($this->object->getPrimaryKey());
        $obj->setUsuariId($value);
        $obj->save();
      }
    }
  }

}
