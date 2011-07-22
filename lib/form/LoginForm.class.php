<?php

class LoginForm extends BaseForm
{
  public function configure()
  {
    $this->setWidgets(array(
        'site'       => new sfWidgetFormChoice(array('choices'=>SitesPeer::getSelect(false,true))),        
      	'nick'   	 => new sfWidgetFormInputText(array(),array('style'=>'width:100px;')),
    	'password' 	 => new sfWidgetFormInputPassword(array(),array('style'=>'width:100px;')),
            	      
    ));        

    
    $this->setValidator('password' , new sfValidatorString(array('required'=>false)));	    	    
    $this->setValidator('nick',new sfValidatorString(array('required'=>false)));
    $this->setValidator('site',new sfValidatorString(array('required'=>true)));        					
    					
    $this->widgetSchema->setlabels(array('nick'=>'DNI: ', 'password'=>'CONTRASENYA: '));

    $this->widgetSchema->setNameFormat('login[%s]');
        
  }
  
}

?>