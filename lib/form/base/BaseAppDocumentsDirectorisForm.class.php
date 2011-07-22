<?php

/**
 * AppDocumentsDirectoris form base class.
 *
 * @method AppDocumentsDirectoris getObject() Returns the current form's model object
 *
 * @package    intranet
 * @subpackage form
 * @author     Your name here
 */
abstract class BaseAppDocumentsDirectorisForm extends BaseFormPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'idDirectori'                     => new sfWidgetFormInputHidden(),
      'Nom'                             => new sfWidgetFormTextarea(),
      'Pare'                            => new sfWidgetFormInputText(),
      'site_id'                         => new sfWidgetFormInputText(),
      'actiu'                           => new sfWidgetFormInputText(),
      'app_documents_permisos_dir_list' => new sfWidgetFormPropelChoice(array('multiple' => true, 'model' => 'Usuaris')),
    ));

    $this->setValidators(array(
      'idDirectori'                     => new sfValidatorChoice(array('choices' => array($this->getObject()->getIddirectori()), 'empty_value' => $this->getObject()->getIddirectori(), 'required' => false)),
      'Nom'                             => new sfValidatorString(),
      'Pare'                            => new sfValidatorInteger(array('min' => -2147483648, 'max' => 2147483647, 'required' => false)),
      'site_id'                         => new sfValidatorInteger(array('min' => -128, 'max' => 127, 'required' => false)),
      'actiu'                           => new sfValidatorInteger(array('min' => -128, 'max' => 127)),
      'app_documents_permisos_dir_list' => new sfValidatorPropelChoice(array('multiple' => true, 'model' => 'Usuaris', 'required' => false)),
    ));

    $this->widgetSchema->setNameFormat('app_documents_directoris[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'AppDocumentsDirectoris';
  }


  public function updateDefaultsFromObject()
  {
    parent::updateDefaultsFromObject();

    if (isset($this->widgetSchema['app_documents_permisos_dir_list']))
    {
      $values = array();
      foreach ($this->object->getAppDocumentsPermisosDirs() as $obj)
      {
        $values[] = $obj->getIdusuari();
      }

      $this->setDefault('app_documents_permisos_dir_list', $values);
    }

  }

  protected function doSave($con = null)
  {
    parent::doSave($con);

    $this->saveAppDocumentsPermisosDirList($con);
  }

  public function saveAppDocumentsPermisosDirList($con = null)
  {
    if (!$this->isValid())
    {
      throw $this->getErrorSchema();
    }

    if (!isset($this->widgetSchema['app_documents_permisos_dir_list']))
    {
      // somebody has unset this widget
      return;
    }

    if (null === $con)
    {
      $con = $this->getConnection();
    }

    $c = new Criteria();
    $c->add(AppDocumentsPermisosDirPeer::IDDIRECTORI, $this->object->getPrimaryKey());
    AppDocumentsPermisosDirPeer::doDelete($c, $con);

    $values = $this->getValue('app_documents_permisos_dir_list');
    if (is_array($values))
    {
      foreach ($values as $value)
      {
        $obj = new AppDocumentsPermisosDir();
        $obj->setIddirectori($this->object->getPrimaryKey());
        $obj->setIdusuari($value);
        $obj->save();
      }
    }
  }

}
