<?php

/**
 * Sites form base class.
 *
 * @method Sites getObject() Returns the current form's model object
 *
 * @package    intranet
 * @subpackage form
 * @author     Your name here
 */
abstract class BaseSitesForm extends BaseFormPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'site_id'            => new sfWidgetFormInputHidden(),
      'nom'                => new sfWidgetFormTextarea(),
      'actiu'              => new sfWidgetFormInputText(),
      'poble'              => new sfWidgetFormInputText(),
      'logoUrl'            => new sfWidgetFormInputText(),
      'webUrl'             => new sfWidgetFormInputText(),
      'telefon'            => new sfWidgetFormInputText(),
      'email'              => new sfWidgetFormInputText(),
      'usuaris_sites_list' => new sfWidgetFormPropelChoice(array('multiple' => true, 'model' => 'Usuaris')),
    ));

    $this->setValidators(array(
      'site_id'            => new sfValidatorChoice(array('choices' => array($this->getObject()->getSiteId()), 'empty_value' => $this->getObject()->getSiteId(), 'required' => false)),
      'nom'                => new sfValidatorString(),
      'actiu'              => new sfValidatorInteger(array('min' => -128, 'max' => 127)),
      'poble'              => new sfValidatorInteger(array('min' => -2147483648, 'max' => 2147483647, 'required' => false)),
      'logoUrl'            => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'webUrl'             => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'telefon'            => new sfValidatorString(array('max_length' => 30, 'required' => false)),
      'email'              => new sfValidatorString(array('max_length' => 50, 'required' => false)),
      'usuaris_sites_list' => new sfValidatorPropelChoice(array('multiple' => true, 'model' => 'Usuaris', 'required' => false)),
    ));

    $this->widgetSchema->setNameFormat('sites[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'Sites';
  }


  public function updateDefaultsFromObject()
  {
    parent::updateDefaultsFromObject();

    if (isset($this->widgetSchema['usuaris_sites_list']))
    {
      $values = array();
      foreach ($this->object->getUsuarisSitess() as $obj)
      {
        $values[] = $obj->getUsuariId();
      }

      $this->setDefault('usuaris_sites_list', $values);
    }

  }

  protected function doSave($con = null)
  {
    parent::doSave($con);

    $this->saveUsuarisSitesList($con);
  }

  public function saveUsuarisSitesList($con = null)
  {
    if (!$this->isValid())
    {
      throw $this->getErrorSchema();
    }

    if (!isset($this->widgetSchema['usuaris_sites_list']))
    {
      // somebody has unset this widget
      return;
    }

    if (null === $con)
    {
      $con = $this->getConnection();
    }

    $c = new Criteria();
    $c->add(UsuarisSitesPeer::SITE_ID, $this->object->getPrimaryKey());
    UsuarisSitesPeer::doDelete($c, $con);

    $values = $this->getValue('usuaris_sites_list');
    if (is_array($values))
    {
      foreach ($values as $value)
      {
        $obj = new UsuarisSites();
        $obj->setSiteId($this->object->getPrimaryKey());
        $obj->setUsuariId($value);
        $obj->save();
      }
    }
  }

}
