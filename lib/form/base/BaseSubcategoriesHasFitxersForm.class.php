<?php

/**
 * SubcategoriesHasFitxers form base class.
 *
 * @package    intranet
 * @subpackage form
 * @author     Albert Johé i Martí
 * @version    SVN: $Id: sfPropelFormGeneratedTemplate.php 16976 2009-04-04 12:47:44Z fabien $
 */
class BaseSubcategoriesHasFitxersForm extends BaseFormPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'Subcategories_idSubcategories' => new sfWidgetFormInputHidden(),
      'Fitxers_FitxersID'             => new sfWidgetFormInputHidden(),
    ));

    $this->setValidators(array(
      'Subcategories_idSubcategories' => new sfValidatorPropelChoice(array('model' => 'Subcategories', 'column' => 'idSubcategories', 'required' => false)),
      'Fitxers_FitxersID'             => new sfValidatorPropelChoice(array('model' => 'Fitxers', 'column' => 'FitxersID', 'required' => false)),
    ));

    $this->widgetSchema->setNameFormat('subcategories_has_fitxers[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'SubcategoriesHasFitxers';
  }


}
