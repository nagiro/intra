<?php

/**
 * Sites form.
 *
 * @package    intranet
 * @subpackage form
 * @author     Albert Johé i Martí
 */
class SitesForm extends BaseSitesForm
{
    
  public function setup()
  {
    
    $this->WEB_IMATGE = 'images/sites/'; 
  	$this->WEB_PDF    = 'images/sites/';   
    $this->BASE       = sfConfig::get('sf_websysroot');
    $this->I          = $this->getObject()->getLogourl(); 
    
    $this->setWidgets(array(
      'site_id'            => new sfWidgetFormInputHidden(),
      'nom'                => new sfWidgetFormInputText(array(),array('style'=>'width:500px')),      
      'webUrl'             => new sfWidgetFormInputText(array(),array('style'=>'width:500px')),
      'logoUrl'            => new sfWidgetFormInputFileEditableMy(array('file_src'=>'/'.$this->WEB_IMATGE.$this->I , 'is_image'=>true,'with_delete'=>false),array('style'=>'width:100px')),
      'actiu'              => new sfWidgetFormInputHidden(array(),array()),      
    ));

    $this->setValidators(array(
      'site_id'            => new sfValidatorChoice(array('choices' => array($this->getObject()->getSiteId()), 'empty_value' => $this->getObject()->getSiteId(), 'required' => false)),
      'nom'                => new sfValidatorString(),
      'logoUrl'            => new sfValidatorFile(array('path'=>$this->BASE.$this->WEB_IMATGE , 'required' => false)),
      'webUrl'             => new sfValidatorString(array('required'=>false)),            
      'actiu'              => new sfValidatorPass(),
    ));

    $this->widgetSchema->setNameFormat('sites[%s]');
    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);
    
    $this->widgetSchema->setLabels(array(        
        'nom' => 'Nom: ',
        'urlWeb' => 'Url del web: ',
        'logoUrl' => 'Logo: ', 
    ));
    
  }

  public function getModelName()
  {
    return 'Sites';
  }
  
  public function save($conn = null)
  {
  	
  	parent::save();
  	
  	$OS = $this->getObject();	  	  	  	  	  	  	  	
  	
  	$BASE = $this->BASE.$this->WEB_IMATGE;  	
  	 	
  	if($OS instanceof Sites):
  	  		
  		$I = $OS->getLogourl();
  		if(!empty($I) && file_exists($BASE.$I)):  				
		  	$img = new sfImage($BASE.$I,'image/jpg');  	
		    $img->resize(150,150);
		    $nom = $OS->getSiteId().'.jpg';
		    $img->saveAs($BASE.$nom);
		    if( $I <> $nom ) unlink($BASE.$I);
		    $OS->setLogourl($nom);		    
	    endif;
	    
	endif;
  	
  	$OS->save();  	
  	  	
  }
  
  
  
}
