<?php

/**
 * Usuaris form.
 *
 * @package    intranet
 * @subpackage form
 * @author     Albert Johé i Martí
 * @version    SVN: $Id: sfPropelFormTemplate.php 10377 2008-07-21 07:10:32Z dwhittle $
 */
class RememberForm extends BaseForm
{
  public function setup()
  {
    $this->setWidgets(array(
      'DNI'          	=> new sfWidgetFormInputText(array(),array('style'=>'width:300px;')),            
      'captcha2'		=> new sfWidgetFormInputCaptcha(array(),array()),               
    ));
        
    $val1 = (date('H',time()) % 10)+1;
    $val2 = (date('d',time()) % 10)+1;        
            
    $sol = $val1+$val2;
    $inv = "El resultat %value% no Ã©s correcte.";    
        
    $this->setValidators(array(
      'DNI'          	=> new sfValidatorPass(array('required'=>true)),      
	  'captcha2'		=> new sfValidatorNumber(array('min'=>$sol,'max'=>$sol,'required'=>false),array('invalid'=>$inv,'max'=>$inv,'min'=>$inv)),      
    ));
    
    $this->widgetSchema->setLabels(array(                
      'DNI'               => 'Entreu el DNI: ',
      'captcha2'		  => 'ValidaciÃ³: ',            
    ));
    
    $this->widgetSchema->setNameFormat('remember[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

  }
  
}
