<?php

/**
 * Nodes form.
 *
 * @package    intranet
 * @subpackage form
 * @author     Albert Joh� i Mart�
 * @version    SVN: $Id: sfPropelFormTemplate.php 10377 2008-07-21 07:10:32Z dwhittle $
 */
class NodesForm extends sfFormPropel
{

  public function setup()
  {
  	
    $this->setWidgets(array(
      'idNodes'     => new sfWidgetFormInputHidden(),
      'TitolMenu'   => new sfWidgetFormInputText(array(),array('style'=>'width:400px')),
      'Nivell'      => new sfWidgetFormChoice(array('choices'=>array(0=>'Fora de menú',1=>'Principal',2=>'Secundari',3=>'Terciari'))),      
      'Ordre'       => new sfWidgetFormChoice(array('choices'=>NodesPeer::selectOrdre($this->getOption('IDS'),$this->isNew()))),      
      'isCategoria' => new sfWidgetFormChoice(array('choices'=>array(1=>'Sí',0=>'No')),array()),
      'isPhp'       => new sfWidgetFormInputHidden(),
      'isActiva'    => new sfWidgetFormChoice(array('choices'=>array(1=>'Sí',0=>'No')),array()),
      'HTML'        => new sfWidgetFormInputHidden(),
      'Url'         => new sfWidgetFormInputText(array(),array('style'=>'width:400px')),
      'Categories'  => new sfWidgetFormChoice(array('choices'=>ActivitatsPeer::selectCategories($this->getOption('IDS') , true)),array()),
    ));

    $this->setValidators(array(
      'idNodes'     => new sfValidatorPropelChoice(array('model' => 'Nodes', 'column' => 'idNodes', 'required' => false)),
      'TitolMenu'   => new sfValidatorString(array('required' => false)),
      'HTML'        => new sfValidatorString(array('required' => false)),
      'isCategoria' => new sfValidatorBoolean(),
      'isPhp'       => new sfValidatorPass(),
      'isActiva'    => new sfValidatorBoolean(),
      'Ordre'       => new sfValidatorInteger(array('required' => false)),
      'Nivell'      => new sfValidatorInteger(),
      'Url'			=> new sfValidatorString(array('required'=>false)),
      'Categories'  => new sfValidatorString(array('required'=>false)),
    ));

    
    $this->widgetSchema->setDefaults(array(      
      'TitolMenu'   => 'Entreu el títol...',
      'Nivell'      => '1',      
      'Ordre'       => '1',      
      'isCategoria' => false,
      'isActiva'    => true,      
      'Url'         => "",
      'Categories'  => "Tipus",
    ));
    
    $this->widgetSchema->setLabels(array(      
      'TitolMenu'   => 'Títol',
      'Nivell'      => 'Nivell',      
      'Ordre'       => 'Ordre',      
      'isCategoria' => 'És només títol?',      
      'isActiva'    => 'Visible?',
      'URL'         => 'Adreça?',
    ));
    
    $this->widgetSchema->setNameFormat('nodes[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'Nodes';
  }
  
  public function save($conn = null)
  {  	
  	$ONodes = $this->getObject();  	
  	NodesPeer::gestionaOrdre($this->getValue('Ordre'),$ONodes->getOrdre(),$this->getOption('IDS'));
  	parent::save();  
  }


}
