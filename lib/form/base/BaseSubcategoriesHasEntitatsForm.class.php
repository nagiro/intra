<?php

/**
 * SubcategoriesHasEntitats form base class.
 *
 * @package    intranet
 * @subpackage form
 * @author     Albert Johé i Martí
 * @version    SVN: $Id: sfPropelFormGeneratedTemplate.php 16976 2009-04-04 12:47:44Z fabien $
 */
class BaseSubcategoriesHasEntitatsForm extends BaseFormPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'Subcategories_idSubcategories' => new sfWidgetFormInputHidden(),
      'Entitats_EntitatID'            => new sfWidgetFormInputHidden(),
    ));

    $this->setValidators(array(
      'Subcategories_idSubcategories' => new sfValidatorPropelChoice(array('model' => 'Subcategories', 'column' => 'idSubcategories', 'required' => false)),
      'Entitats_EntitatID'            => new sfValidatorPropelChoice(array('model' => 'Entitats', 'column' => 'EntitatID', 'required' => false)),
    ));

    $this->widgetSchema->setNameFormat('subcategories_has_entitats[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'SubcategoriesHasEntitats';
  }


}
