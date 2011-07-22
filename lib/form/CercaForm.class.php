<?php

class CercaForm extends BaseForm
{
  public function configure()
  {
    $this->setWidgets(array(
      'text'    => new sfWidgetFormInputText()      
    ));
    
        
    $this->setDefault('text','Entra el text a cercar');    
    $this->setValidator('text',new sfValidatorString(array('required'=>false)));

    $this->widgetSchema->setlabels(array('text'=>'CERCA:'));
    $this->widgetSchema->setNameFormat('cerca[%s]');
    
    
  }
}

?>
