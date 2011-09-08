<?php

/**
 * Usuaris form.
 *
 * @package    intranet
 * @subpackage form
 * @author     Albert Johé i Martí
 * @version    SVN: $Id: sfPropelFormTemplate.php 10377 2008-07-21 07:10:32Z dwhittle $
 */
class ClientUsuarisForm extends UsuarisForm
{
	
	
  public function setup()
  {
    
    parent::setup();
    
    $this->setWidget('Nivells_idNivells',new sfWidgetFormInputHidden());
    $this->setWidget('Habilitat',new sfWidgetFormInputHidden());
    $this->setWidget('captcha2',new sfWidgetFormInputCaptcha(array(),array()));

    $val1 = (date('H',time()) % 10)+1;
    $val2 = (date('d',time()) % 10)+1;        
    
    $sol = $val1+$val2;
    $inv = "El resultat %value% no és correcte.";

	$this->setValidator('captcha2',new sfValidatorNumber(array('min'=>$sol,'max'=>$sol),array('invalid'=>$inv,'max'=>$inv,'min'=>$inv)));       
    $this->widgetSchema->setLabel('captcha2','Verificació: ');

  }
  
  public function save($conn = null)
  {
    parent::save();
      	
  	$OU = $this->getObject();  	
  	$OU->setNivellsIdnivells(Nivells::USER);  	
  	$OU->save();  
  }    
      
}
