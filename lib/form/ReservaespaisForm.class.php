<?php

/**
 * Reservaespais form.
 *
 * @package    intranet
 * @subpackage form
 * @author     Albert Joh� i Mart�
 * @version    SVN: $Id: sfPropelFormTemplate.php 10377 2008-07-21 07:10:32Z dwhittle $
 */
class ReservaespaisForm extends sfFormPropel
{
	
  public function setup()
  {
  	
  	$SN = array(true=>'Sí',false=>'No');
  	
  	$this->setWidgets(array(
  	  'Codi'               => new sfWidgetFormInputText(array(),array()),
  	  'Estat'              => new sfWidgetFormChoice(array('choices'=>ReservaespaisPeer::selectEstat())),
  	  'CondicionsCCG'      => new sfWidgetFormTextareaTinyMCE(),
      'ReservaEspaiID'     => new sfWidgetFormInputHidden(),
      'Nom'                => new sfWidgetFormInputText(array(),array('style'=>'width:400px')),
      'DataActivitat'      => new sfWidgetFormInputText(array(),array('style'=>'width:400px')),
      'HorariActivitat'    => new sfWidgetFormInputText(array(),array('style'=>'width:400px')),
      'EspaisSolicitats'   => new sfWidgetFormChoice(array('renderer_class'=>'sfWidgetFormSelectManyMy' , 'choices'=>EspaisPeer::selectFormReserva($this->getOption('IDS')) , 'multiple'=>true , 'expanded'=>true),array('class'=>'ul_espais')),
      'MaterialSolicitat'  => new sfWidgetFormChoice(array('renderer_class'=>'sfWidgetFormSelectManyMy' , 'choices'=>MaterialgenericPeer::selectFormulariUsuaris(), 'multiple'=>true , 'expanded'=>true),array('class'=>'ul_material')),
      'TipusActe'          => new sfWidgetFormInputText(array(),array('style'=>'width:400px')),    
      'Representacio'      => new sfWidgetFormInputText(array(),array('style'=>'width:400px')),    
      'Responsable'        => new sfWidgetFormInputText(array(),array('style'=>'width:400px')),
      'Organitzadors'      => new sfWidgetFormInputText(array(),array('style'=>'width:400px')),
      'PersonalAutoritzat' => new sfWidgetFormInputText(array(),array('style'=>'width:400px')),    
      'PrevisioAssistents' => new sfWidgetFormInputText(array(),array('style'=>'width:400px')),
      'isEnregistrable'    => new sfWidgetFormChoice(array('choices'=>$SN),array()),
      'EsCicle'            => new sfWidgetFormChoice(array('choices'=>$SN),array()),          
      'Comentaris'         => new sfWidgetFormTextarea(array(),array('rows'=>'10','cols'=>'50')),      
      'Usuaris_usuariID'   => new sfWidgetFormInputHidden(),            
      'DataAlta'           => new sfWidgetFormInputHidden(),      
      'DataAcceptacioCondicions' => new sfWidgetFormInputHidden(),
      'ObservacionsCondicions' => new sfWidgetFormTextarea(array(),array('rows'=>'10','cols'=>'50')),
  	  
    ));
  	  	
    $this->setValidators(array(
      'Codi'               => new sfValidatorPass(array('required'=>false),array()),
      'ReservaEspaiID'     => new sfValidatorPropelChoice(array('model' => 'Reservaespais', 'column' => 'ReservaEspaiID', 'required' => false)),
      'Representacio'      => new sfValidatorString(array('required' => true)),
      'Responsable'        => new sfValidatorString(array('required' => true)),
      'PersonalAutoritzat' => new sfValidatorString(array('required' => true)),
      'PrevisioAssistents' => new sfValidatorInteger(array('required' => true)),
      'EsCicle'            => new sfValidatorBoolean(array('required' => true)),
      'Comentaris'         => new sfValidatorString(array('required' => false)),
      'Estat'              => new sfValidatorString(array('max_length' => 1, 'required' => true)),
      'Usuaris_usuariID'   => new sfValidatorPropelChoice(array('model' => 'Usuaris', 'column' => 'UsuariID', 'required' => true)),
      'Organitzadors'      => new sfValidatorString(array('required' => true)),
      'DataActivitat'      => new sfValidatorString(array('required' => true)),
      'HorariActivitat'    => new sfValidatorString(array('required' => true)),
      'TipusActe'          => new sfValidatorString(array('required' => true)),
      'Nom'                => new sfValidatorString(array('required' => true)),
      'isEnregistrable'    => new sfValidatorBoolean(array('required' => true)),
      'DataAlta'           => new sfValidatorDateTime(array('required' => false)),
      'EspaisSolicitats'   => new sfValidatorString(array('required' => false)),
      'MaterialSolicitat'  => new sfValidatorString(array('required' => false)),      
      'CondicionsCCG'      => new sfValidatorPass(),
      'DataAcceptacioCondicions' => new sfValidatorPass(),
      'ObservacionsCondicions' => new sfValidatorString(array('required'=>false)),    
    ));
    
    $this->widgetSchema->setLabels(array(
      'Codi'			   => "Codi: ",
      'Estat'			   => "Estat actual: ",      
      'Nom'                => "Nom de l'activitat: ",
      'DataActivitat'      => "Proposta de data: ",
      'HorariActivitat'    => "Horari de l'activitat: ",
      'Espais'             => 'Espais: (<a class="blue" href="'.sfConfig::get('sf_webroot').'intranet_dev.php/web/espais" target="_NEW">veure\'ls</a>)',
      'Material'		   => "Material: ",
      'TipusActe'          => "Tipus d'acte: ",    
      'isEnregistrable'    => "És enregistrable?",
      'Representacio'      => "En representació de: ",    
      'Responsable'        => "Responsable: ",
      'Organitzadors'      => "Organitzadors: ",
      'PersonalAutoritzat' => "Personal autoritzat: ",    
      'PrevisioAssistents' => "Previsió d'assistents: ",
      'EsCicle'            => "És un cicle? ",
      'Comentaris'         => "Comentaris: ",
      'EspaisSolicitats'   => 'Espais: ',
      'MaterialSolicitat'  => 'Material: ',      
      'ObservacionsCondicions' => "Observacions ",
      'CondicionsCCG'      => 'Condicions ',
    ));
    
    $this->widgetSchema->setNameFormat('reservaespais[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);
 
    $this->widgetSchema->setFormFormatterName('Span');
    
    
  }

  public function getModelName()
  {
    return 'Reservaespais';
  }

  public function save($conn = null)
  {
  	
	$this->updateObject();
  	$OR = $this->getObject();  	  	  	  	  	
  	if(!is_null($this['MaterialSolicitat']->getValue())) $OR->setMaterialsolicitat(implode('@',$this['MaterialSolicitat']->getValue()));
  	if(!is_null($this['EspaisSolicitats']->getValue())) $OR->setEspaissolicitats(implode('@',$this['EspaisSolicitats']->getValue()));  	  	
  	$OR->save();  	
  	
  }
  
}
