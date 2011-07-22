<?php

/**
 * Agendatelefonica form.
 *
 * @package    intranet
 * @subpackage form
 * @author     Albert Johé i Martí
 * @version    SVN: $Id: sfPropelFormTemplate.php 10377 2008-07-21 07:10:32Z dwhittle $
 */
class AgendatelefonicaForm extends BaseFormPropel
{
	
  public function setup()
  {
  	  	
  	
    $this->setWidgets(array(
      'AgendaTelefonicaID' => new sfWidgetFormInputHidden(),
      'Nom'                => new sfWidgetFormInputText(array(),array('class'=>'cent')),
      'NIF'                => new sfWidgetFormInputText(array(),array('class'=>'cent')),      
      'Notes'              => new sfWidgetFormTextarea(array(),array('class'=>'cent')),
      'Tags'               => new sfWidgetFormInputText(array(),array('class'=>'cent')),
      'Entitat'            => new sfWidgetFormInputText(array(),array('class'=>'cent')),
      'site_id'            => new sfWidgetFormInputHidden(array(),array()),
      'actiu'              => new sfWidgetFormInputHidden(array(),array()),
    ));

    $this->setValidators(array(
      'AgendaTelefonicaID' => new sfValidatorPropelChoice(array('model' => 'Agendatelefonica', 'column' => 'AgendaTelefonicaID', 'required' => false)),
      'Nom'                => new sfValidatorString(array('required' => false)),
      'NIF'                => new sfValidatorString(array('required' => false)),
      'Notes'              => new sfValidatorString(array('required' => false)),
      'Tags'               => new sfValidatorString(array('required' => false)),
      'Entitat'            => new sfValidatorString(array('required' => false)),
      'site_id'            => new sfValidatorPass(array('required'=>false)),
      'actiu'              => new sfValidatorPass(array('required'=>false)),
    ));

    $this->widgetSchema->setNameFormat('agendatelefonica[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);
    
    $this->widgetSchema->setFormFormatterName('Span');
    
    
    //unset($this['dataalta']);
  
	$this->widgetSchema->setLabels(array(
	      	'Nom'    	=> 'Nom : ',
	      	'NIF'      	=> 'DNI : ',	      	
			'Notes'   	=> 'Notes : ',
			'Tags'   	=> 'Tags :',
			'Entitat'   => 'Entitat : ',
	
	));
	  
   	$this->widgetSchema->setHelp('is_public', 'Whether the job can also be published on affiliate websites or not.');  		
	
  }
  
  public function getModelName()
  {
    return 'Agendatelefonica';
  }
  	
}
