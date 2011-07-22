<?php

/**
 * SubcategoriesHasProjectes form base class.
 *
 * @package    intranet
 * @subpackage form
 * @author     Albert Johé i Martí
 * @version    SVN: $Id: sfPropelFormGeneratedTemplate.php 16976 2009-04-04 12:47:44Z fabien $
 */
class BaseSubcategoriesHasProjectesForm extends BaseFormPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'Subcategories_idSubcategories' => new sfWidgetFormInputHidden(),
      'Projectes_idProjectes'         => new sfWidgetFormInputHidden(),
    ));

    $this->setValidators(array(
      'Subcategories_idSubcategories' => new sfValidatorPropelChoice(array('model' => 'Subcategories', 'column' => 'idSubcategories', 'required' => false)),
      'Projectes_idProjectes'         => new sfValidatorPropelChoice(array('model' => 'Projectes', 'column' => 'idProjectes', 'required' => false)),
    ));

    $this->widgetSchema->setNameFormat('subcategories_has_projectes[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'SubcategoriesHasProjectes';
  }


}
