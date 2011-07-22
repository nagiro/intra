<?php

/**
 * AppDocumentsDirectoris form.
 *
 * @package    intranet
 * @subpackage form
 * @author     Albert Johé i Martí
 * @version    SVN: $Id: sfPropelFormTemplate.php 10377 2008-07-21 07:10:32Z dwhittle $
 */
class AppDocumentsDirectorisForm extends BaseAppDocumentsDirectorisForm
{
	
  public function setup()
  {
  	
    $this->setWidgets(array(
      'idDirectori'                     => new sfWidgetFormInputHidden(),
      'Pare'                            => new sfWidgetFormChoice(array('choices'=>AppDocumentsDirectorisPeer::getSelectDirectoris($this->getOption('IDS'))),array()),
      'Nom'                             => new sfWidgetFormInputText(array(),array('style'=>'width:200px')), 
    ));

    $this->setValidators(array(
      'idDirectori'                     => new sfValidatorPropelChoice(array('model' => 'AppDocumentsDirectoris', 'column' => 'idDirectori', 'required' => false)),
      'Nom'                             => new sfValidatorString(array('required'=>true)),
      'Pare'                            => new sfValidatorPass(array('required'=>true)),      
    ));

    $this->widgetSchema->setNameFormat('app_documents_directoris[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);
    
  }

  public function getModelName()
  {
    return 'AppDocumentsDirectoris';
  }
	
}
