<?php

/**
 * Activitats form.
 *
 * @package    intranet
 * @subpackage form
 * @author     Albert Johé i Martí
 * @version    SVN: $Id: sfPropelFormTemplate.php 10377 2008-07-21 07:10:32Z dwhittle $
 */
class ActivitatsPas1Form extends BaseForm
{
	
  public function setup()
  {
    $this->setWidgets(array(
      'cicle'                     		=> new sfWidgetFormChoice(array('choices'=>array(1=>'SÃ³n activitats soltes',2=>'Ã‰s un cicle / festival / projecte')),array()),
      'nom'								=> new sfWidgetFormInputText(array(),array()),      
    ));

    $this->setValidators(array(
	  'cicle'                     		=> new sfValidatorPass(),
      'nom'								=> new sfValidatorString(),    	      
    ));

    $this->widgetSchema->setLabels(array(
      'cicle'							=> 'Tipologia',
      'nom'								=> 'Nom genÃ¨ric',      
    ));
    
    
    $this->widgetSchema->setNameFormat('activitats[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);
    
    $this->widgetSchema->setFormFormatterName('Span');

  }

}
