<?php

/**
 * Promocions form.
 *
 * @package    intranet
 * @subpackage form
 * @author     Albert Johé i Martí
 * @version    SVN: $Id: sfPropelFormTemplate.php 10377 2008-07-21 07:10:32Z dwhittle $
 */
class PromocionsForm extends sfFormPropel
{
	
  public function setup()
  {
  	
    $this->URL = OptionsPeer::getString('SF_WEBSYSROOT',$this->getOption('IDS')).'images/banners/';    
    $this->WEB_URL = OptionsPeer::getString('SF_WEBROOTURL',$this->getOption('IDS')).'images/banners/'.$this->getObject()->getExtensio(); 
    
    $this->setWidgets(array(
      'PromocioID' => new sfWidgetFormInputHidden(),
      'Nom'        => new sfWidgetFormInputText(array(),array('style'=>'width:400px')),
      'URL'        => new sfWidgetFormInputText(array(),array('style'=>'width:400px')),
      'Ordre'      => new sfWidgetFormChoice(array('choices'=>PromocionsPeer::selectOrdre($this->getOption('IDS'),$this->isNew()))),    
      'isActiva'   => new sfWidgetFormChoice(array('choices'=>array(1=>'Sí',0=>'No')),array('value'=>1)),
      'isFixa'     => new sfWidgetFormChoice(array('choices'=>array(1=>'Sí',0=>'No')),array('value'=>1)),
      'Extensio'   => new sfWidgetFormInputFileEditable(array('file_src'=>$this->WEB_URL,'edit_mode'=>true,'is_image'=>true,'with_delete'=>false)),
            
    ));
    
    $this->setValidators(array(
      'PromocioID' => new sfValidatorPropelChoice(array('model' => 'Promocions', 'column' => 'PromocioID', 'required' => false)),
      'Nom'        => new sfValidatorString(array('required' => false)),
      'Ordre'      => new sfValidatorInteger(array('required' => false)),            
      'isActiva'   => new sfValidatorInteger(array('required' => false)),
      'isFixa'     => new sfValidatorInteger(),
      'URL'        => new sfValidatorString(array('required'=>false)),
      'Extensio'   => new sfValidatorFile(array('path'=>$this->URL , 'required' => false)),
    ));
        
    $this->widgetSchema->setLabels(array(      
      'Nom'        => 'Títol',
      'Ordre'      => 'Ordre',    
      'isActiva'   => 'Activa?',
      'isFixa'     => 'Fixe?',
      'URL'        => 'URL',
    ));
        
    $this->widgetSchema->setNameFormat('promocions[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);
    
  }

  public function getModelName()
  {
    return 'Promocions';
  }
  
  public function save($conn = null)
  {
 	
  	$OPromocions = $this->getObject();             	
  	PromocionsPeer::gestionaOrdre($this->getValue('Ordre'),$OPromocions->getOrdre(),$this->getOption('IDS'));
    
    parent::save();
    
    $nom = $OPromocions->getExtensio();
    if(!empty($nom)):
        $img = new sfImage($this->URL.$nom, 'image/jpg');
        $img->resize(171,63)->saveAs($this->URL.$nom);        
    endif;  	  	   		  	  	
  	   	
  }  
  
}
