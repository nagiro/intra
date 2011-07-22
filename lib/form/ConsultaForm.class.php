<?php

/**
 * Activitats form.
 *
 * @package    intranet
 * @subpackage form
 * @author     Albert Johé i Martí
 * @version    SVN: $Id: sfPropelFormTemplate.php 10377 2008-07-21 07:10:32Z dwhittle $
 */
class ConsultaForm extends BaseForm
{
  public function setup()
  {
    $this->setWidgets(array(
      'Nom'                     		=> new sfWidgetFormInputText(array(),array('style'=>'width:400px')),
      'Cognoms'                         => new sfWidgetFormInputText(array(),array('style'=>'width:400px')),    
      'Telefon'                  		=> new sfWidgetFormInputText(array(),array('style'=>'width:400px')),
      'Email' 							=> new sfWidgetFormInputText(array(),array('style'=>'width:400px')),
      'Missatge'                        => new sfWidgetFormTextarea(array(),array('style'=>'width:400px')),      
    ));

    $this->setValidators(array(
      'Nom'                     		=> new sfValidatorString(),
      'Cognoms'                         => new sfValidatorString(),    
      'Telefon'                  		=> new sfValidatorString(),
      'Email' 							=> new sfValidatorString(),
      'Missatge'                        => new sfValidatorString(),      
    ));

    $this->widgetSchema->setLabels(array(      
      'Nom'                     		=> 'Nom: ',
      'Cognoms'                         => 'Cognoms: ',   
      'Telefon'                  		=> 'TelÃ¨fon: ',
      'Email' 							=> 'Correu electrÃ²nic: ',
      'Missatge'                        => 'Missatge: ',
    ));
    
    
    $this->widgetSchema->setNameFormat('consulta[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'Consulta';
  }

}
