<?php

/**
 * Llistes form base class.
 *
 * @method Llistes getObject() Returns the current form's model object
 *
 * @package    intranet
 * @subpackage form
 * @author     Your name here
 */
abstract class BaseLlistesForm extends BaseFormPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'idLlistes'             => new sfWidgetFormInputHidden(),
      'Nom'                   => new sfWidgetFormTextarea(),
      'isActiva'              => new sfWidgetFormInputText(),
      'site_id'               => new sfWidgetFormInputText(),
      'actiu'                 => new sfWidgetFormInputText(),
      'missatgesllistes_list' => new sfWidgetFormPropelChoice(array('multiple' => true, 'model' => 'Missatgesmailing')),
    ));

    $this->setValidators(array(
      'idLlistes'             => new sfValidatorChoice(array('choices' => array($this->getObject()->getIdllistes()), 'empty_value' => $this->getObject()->getIdllistes(), 'required' => false)),
      'Nom'                   => new sfValidatorString(),
      'isActiva'              => new sfValidatorInteger(array('min' => -128, 'max' => 127)),
      'site_id'               => new sfValidatorInteger(array('min' => -128, 'max' => 127, 'required' => false)),
      'actiu'                 => new sfValidatorInteger(array('min' => -128, 'max' => 127)),
      'missatgesllistes_list' => new sfValidatorPropelChoice(array('multiple' => true, 'model' => 'Missatgesmailing', 'required' => false)),
    ));

    $this->widgetSchema->setNameFormat('llistes[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'Llistes';
  }


  public function updateDefaultsFromObject()
  {
    parent::updateDefaultsFromObject();

    if (isset($this->widgetSchema['missatgesllistes_list']))
    {
      $values = array();
      foreach ($this->object->getMissatgesllistess() as $obj)
      {
        $values[] = $obj->getIdmissatgesllistes();
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
    $c->add(MissatgesllistesPeer::LLISTES_IDLLISTES, $this->object->getPrimaryKey());
    MissatgesllistesPeer::doDelete($c, $con);

    $values = $this->getValue('missatgesllistes_list');
    if (is_array($values))
    {
      foreach ($values as $value)
      {
        $obj = new Missatgesllistes();
        $obj->setLlistesIdllistes($this->object->getPrimaryKey());
        $obj->setIdmissatgesllistes($value);
        $obj->save();
      }
    }
  }

}
