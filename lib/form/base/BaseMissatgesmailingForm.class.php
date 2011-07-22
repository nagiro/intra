<?php

/**
 * Missatgesmailing form base class.
 *
 * @method Missatgesmailing getObject() Returns the current form's model object
 *
 * @package    intranet
 * @subpackage form
 * @author     Your name here
 */
abstract class BaseMissatgesmailingForm extends BaseFormPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'idMissatge'            => new sfWidgetFormInputHidden(),
      'titol'                 => new sfWidgetFormTextarea(),
      'text'                  => new sfWidgetFormTextarea(),
      'data_alta'             => new sfWidgetFormDate(),
      'site_id'               => new sfWidgetFormInputText(),
      'actiu'                 => new sfWidgetFormInputText(),
      'missatgesllistes_list' => new sfWidgetFormPropelChoice(array('multiple' => true, 'model' => 'Llistes')),
    ));

    $this->setValidators(array(
      'idMissatge'            => new sfValidatorChoice(array('choices' => array($this->getObject()->getIdmissatge()), 'empty_value' => $this->getObject()->getIdmissatge(), 'required' => false)),
      'titol'                 => new sfValidatorString(),
      'text'                  => new sfValidatorString(),
      'data_alta'             => new sfValidatorDate(),
      'site_id'               => new sfValidatorInteger(array('min' => -128, 'max' => 127, 'required' => false)),
      'actiu'                 => new sfValidatorInteger(array('min' => -128, 'max' => 127)),
      'missatgesllistes_list' => new sfValidatorPropelChoice(array('multiple' => true, 'model' => 'Llistes', 'required' => false)),
    ));

    $this->widgetSchema->setNameFormat('missatgesmailing[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'Missatgesmailing';
  }


  public function updateDefaultsFromObject()
  {
    parent::updateDefaultsFromObject();

    if (isset($this->widgetSchema['missatgesllistes_list']))
    {
      $values = array();
      foreach ($this->object->getMissatgesllistess() as $obj)
      {
        $values[] = $obj->getLlistesIdllistes();
      }

      $this->setDefault('missatgesllistes_list', $values);
    }

  }

  protected function doSave($con = null)
  {
    parent::doSave($con);

    $this->saveMissatgesllistesList($con);
  }

  public function saveMissatgesllistesList($con = null)
  {
    if (!$this->isValid())
    {
      throw $this->getErrorSchema();
    }

    if (!isset($this->widgetSchema['missatgesllistes_list']))
    {
      // somebody has unset this widget
      return;
    }

    if (null === $con)
    {
      $con = $this->getConnection();
    }

    $c = new Criteria();
    $c->add(MissatgesllistesPeer::IDMISSATGESLLISTES, $this->object->getPrimaryKey());
    MissatgesllistesPeer::doDelete($c, $con);

    $values = $this->getValue('missatgesllistes_list');
    if (is_array($values))
    {
      foreach ($values as $value)
      {
        $obj = new Missatgesllistes();
        $obj->setIdmissatgesllistes($this->object->getPrimaryKey());
        $obj->setLlistesIdllistes($value);
        $obj->save();
      }
    }
  }

}
