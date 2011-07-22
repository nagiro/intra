<?php

/**
 * AppDocumentsArxius form base class.
 *
 * @method AppDocumentsArxius getObject() Returns the current form's model object
 *
 * @package    intranet
 * @subpackage form
 * @author     Your name here
 */
abstract class BaseAppDocumentsArxiusForm extends BaseFormPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'idDocument'                  => new sfWidgetFormInputHidden(),
      'idDirectori'                 => new sfWidgetFormPropelChoice(array('model' => 'AppDocumentsDirectoris', 'add_empty' => true)),
      'Nom'                         => new sfWidgetFormTextarea(),
      'url'                         => new sfWidgetFormTextarea(),
      'DataCreacio'                 => new sfWidgetFormDate(),
      'site_id'                     => new sfWidgetFormInputText(),
      'actiu'                       => new sfWidgetFormInputText(),
      'app_documents_permisos_list' => new sfWidgetFormPropelChoice(array('multiple' => true, 'model' => 'Usuaris')),
    ));

    $this->setValidators(array(
      'idDocument'                  => new sfValidatorChoice(array('choices' => array($this->getObject()->getIddocument()), 'empty_value' => $this->getObject()->getIddocument(), 'required' => false)),
      'idDirectori'                 => new sfValidatorPropelChoice(array('model' => 'AppDocumentsDirectoris', 'column' => 'idDirectori', 'required' => false)),
      'Nom'                         => new sfValidatorString(),
      'url'                         => new sfValidatorString(),
      'DataCreacio'                 => new sfValidatorDate(),
      'site_id'                     => new sfValidatorInteger(array('min' => -128, 'max' => 127, 'required' => false)),
      'actiu'                       => new sfValidatorInteger(array('min' => -128, 'max' => 127)),
      'app_documents_permisos_list' => new sfValidatorPropelChoice(array('multiple' => true, 'model' => 'Usuaris', 'required' => false)),
    ));

    $this->widgetSchema->setNameFormat('app_documents_arxius[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'AppDocumentsArxius';
  }


  public function updateDefaultsFromObject()
  {
    parent::updateDefaultsFromObject();

    if (isset($this->widgetSchema['app_documents_permisos_list']))
    {
      $values = array();
      foreach ($this->object->getAppDocumentsPermisoss() as $obj)
      {
        $values[] = $obj->getIdusuari();
      }

      $this->setDefault('app_documents_permisos_list', $values);
    }

  }

  protected function doSave($con = null)
  {
    parent::doSave($con);

    $this->saveAppDocumentsPermisosList($con);
  }

  public function saveAppDocumentsPermisosList($con = null)
  {
    if (!$this->isValid())
    {
      throw $this->getErrorSchema();
    }

    if (!isset($this->widgetSchema['app_documents_permisos_list']))
    {
      // somebody has unset this widget
      return;
    }

    if (null === $con)
    {
      $con = $this->getConnection();
    }

    $c = new Criteria();
    $c->add(AppDocumentsPermisosPeer::IDARXIU, $this->object->getPrimaryKey());
    AppDocumentsPermisosPeer::doDelete($c, $con);

    $values = $this->getValue('app_documents_permisos_list');
    if (is_array($values))
    {
      foreach ($values as $value)
      {
        $obj = new AppDocumentsPermisos();
        $obj->setIdarxiu($this->object->getPrimaryKey());
        $obj->setIdusuari($value);
        $obj->save();
      }
    }
  }

}
