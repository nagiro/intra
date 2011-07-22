<?php

class EditorHtmlForm extends BaseNodesForm
{
  public function setup()
  {

//    parent::setup();
    $this->setWidget('idNodes',new sfWidgetFormInputHidden(array(),array()));
    $this->setValidator('idNodes',new sfValidatorString(array('required'=>false)));                        
    $this->setWidget('HTML',new sfWidgetFormTextareaTinyMCE(array(),array()));
    $this->setValidator('HTML',new sfValidatorString(array('required'=>false)));
    
    $this->widgetSchema->setNameFormat('editor[%s]');
            
  }
  
  public function setChoice(array $Choice)
  {
  	$this['select']->getWidget()->setOption('choices',$Choice);  	  
  }
  
  
}

?>
