<?php

/**
 * Categories form base class.
 *
 * @package    intranet
 * @subpackage form
 * @author     Albert Johé i Martí
 * @version    SVN: $Id: sfPropelFormGeneratedTemplate.php 16976 2009-04-04 12:47:44Z fabien $
 */
class BaseCategoriesForm extends BaseFormPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'idCategories' => new sfWidgetFormInputHidden(),
      'Tipus'        => new sfWidgetFormInputText(),
      'Categoria'    => new sfWidgetFormInputText(),
    ));

    $this->setValidators(array(
      'idCategories' => new sfValidatorPropelChoice(array('model' => 'Categories', 'column' => 'idCategories', 'required' => false)),
      'Tipus'        => new sfValidatorString(array('max_length' => 1, 'required' => false)),
      'Categoria'    => new sfValidatorString(array('max_length' => 100, 'required' => false)),
    ));

    $this->widgetSchema->setNameFormat('categories[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'Categories';
  }


}
