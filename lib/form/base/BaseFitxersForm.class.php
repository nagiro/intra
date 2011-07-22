<?php

/**
 * Fitxers form base class.
 *
 * @package    intranet
 * @subpackage form
 * @author     Albert Johé i Martí
 * @version    SVN: $Id: sfPropelFormGeneratedTemplate.php 16976 2009-04-04 12:47:44Z fabien $
 */
class BaseFitxersForm extends BaseFormPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'FitxersID'                      => new sfWidgetFormInputHidden(),
      'Usuaris_idUsuari'               => new sfWidgetFormPropelChoice(array('model' => 'Usuaris', 'add_empty' => false)),
      'EsDocument'                     => new sfWidgetFormInputText(),
      'URL'                            => new sfWidgetFormTextarea(),
      'Nom'                            => new sfWidgetFormTextarea(),
      'Descripcio'                     => new sfWidgetFormTextarea(),
      'Tags'                           => new sfWidgetFormTextarea(),
      'DATE'                           => new sfWidgetFormDateTime(),
      'Extensio'                       => new sfWidgetFormTextarea(),
      'subcategories_has_fitxers_list' => new sfWidgetFormPropelChoice(array('model' => 'Subcategories', 'multiple'=>true)),
    ));

    $this->setValidators(array(
      'FitxersID'                      => new sfValidatorPropelChoice(array('model' => 'Fitxers', 'column' => 'FitxersID', 'required' => false)),
      'Usuaris_idUsuari'               => new sfValidatorPropelChoice(array('model' => 'Usuaris', 'column' => 'UsuariID')),
      'EsDocument'                     => new sfValidatorInteger(array('required' => false)),
      'URL'                            => new sfValidatorString(array('required' => false)),
      'Nom'                            => new sfValidatorString(array('required' => false)),
      'Descripcio'                     => new sfValidatorString(array('required' => false)),
      'Tags'                           => new sfValidatorString(array('required' => false)),
      'DATE'                           => new sfValidatorDateTime(array('required' => false)),
      'Extensio'                       => new sfValidatorString(),
      'subcategories_has_fitxers_list' => new sfValidatorPropelChoice(array('model' => 'Subcategories', 'required' => false, 'multiple'=>true)),
    ));

    $this->widgetSchema->setNameFormat('fitxers[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'Fitxers';
  }


  public function updateDefaultsFromObject()
  {
    parent::updateDefaultsFromObject();

    if (isset($this->widgetSchema['subcategories_has_fitxers_list']))
    {
      $values = array();
      foreach ($this->object->getSubcategoriesHasFitxerss() as $obj)
      {
        $values[] = $obj->getSubcategoriesIdsubcategories();
      }

      $this->setDefault('subcategories_has_fitxers_list', $values);
    }

  }

  protected function doSave($con = null)
  {
    parent::doSave($con);

    $this->saveSubcategoriesHasFitxersList($con);
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
    $c->add(SubcategoriesHasFitxersPeer::FITXERS_FITXERSID, $this->object->getPrimaryKey());
    SubcategoriesHasFitxersPeer::doDelete($c, $con);

    $values = $this->getValue('subcategories_has_fitxers_list');
    if (is_array($values))
    {
      foreach ($values as $value)
      {
        $obj = new SubcategoriesHasFitxers();
        $obj->setFitxersFitxersid($this->object->getPrimaryKey());
        $obj->setSubcategoriesIdsubcategories($value);
        $obj->save();
      }
    }
  }

}
