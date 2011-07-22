<?php

class CercaTextChoiceForm extends BaseForm
{
  public function configure()
  {
    $this->setWidgets(array(
      'text'    => new sfWidgetFormInputText(),
      'select'  => new sfWidgetFormChoice(array('choices'=>array()))            
    ));
    
        
    $this->setDefault('text','Entra el text a cercar');    
    $this->setValidator('text',new sfValidatorString(array('required'=>false)));
    $this->setValidator('select',new sfValidatorString(array('required'=>false)));

    $this->widgetSchema->setlabels(array('text'=>'CERCA'));
    $this->widgetSchema->setNameFormat('cerca[%s]');
    $this->widgetSchema->setFormFormatterName('Horizontal');
    
    
  }
  
  public function setChoice(array $Choice)
  {
  	$this['select']->getWidget()->setOption('choices',$Choice);  	  
  }
  
}

?>
