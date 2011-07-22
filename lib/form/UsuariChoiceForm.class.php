<?php

/**
 * Matricules form.
 *
 * @package    intranet
 * @subpackage form
 * @author     Albert Johé i Martí
 * @version    SVN: $Id: sfPropelFormTemplate.php 10377 2008-07-21 07:10:32Z dwhittle $
 */
class UsuariChoiceForm extends BaseForm
{
	
  public function setup()
  {  	
  	
  	$this->setWidgets(array(
  	  'idUsuari' => new sfWidgetFormJQueryAutocompleter(array('config'=>'{ max:20 , width:500 }' , 'url'=>$this->getOption('url'))),  	    	    	  
    ));

    $this->setValidators(array(      
      'idUsuari'     => new sfValidatorPass(),         
    ));

    $this->widgetSchema->setLabels(array(                  
      'idUsuari' => 'Usuari: ',
    ));    
    
    $this->widgetSchema->setNameFormat('usuari_choice[%s]');
    
    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

  }
  
}
