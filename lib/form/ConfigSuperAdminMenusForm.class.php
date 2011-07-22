<?php

class ConfigSuperAdminMenusForm extends sfForm
{
	
  public function setup()
  {
    
    $BASE = OptionsPeer::getString('SF_WEBROOT',$this->getOption('IDS'));         
      	
  	$this->setWidget('IDS', new sfWidgetFormChoice(
                                        array(
                                            'choices'=>SitesPeer::getSelect(false,false)),                        
                                        array(
                                            'style'=>'width:400px')));                                	    	    	    	          	    	                            

    $this->setValidator('IDS', new sfValidatorPass(array(),array()));    
    
    $this->widgetSchema->setNameFormat('super_admin_menus[%s]');
    
    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);
        
    $this->setWidgetUsers();
    
  }
  
  public function setWidgetUsers()
  {
    $this->setWidget('IDU', new sfWidgetFormChoice(
                        array(
                            'choices'=>UsuarisSitesPeer::getSitesUsersSelect($this->getValue('IDS'),NivellsPeer::ADMIN)                            
                        )));
    $this->setValidator('IDU', new sfValidatorPass(array(),array()));
  }

}
