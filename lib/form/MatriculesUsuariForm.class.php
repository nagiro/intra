<?php

/**
 * Matricules form.
 *
 * @package    intranet
 * @subpackage form
 * @author     Albert Joh� i Mart�
 * @version    SVN: $Id: sfPropelFormTemplate.php 10377 2008-07-21 07:10:32Z dwhittle $
 */
class MatriculesUsuariForm extends sfFormPropel
{
	
  public function setup()
  {
    
    $BASE = OptionsPeer::getString('SF_WEBROOT',$this->getOption('IDS'));    
          	
  	$this->setWidgets(array(
      'idMatricules'     => new sfWidgetFormInputHidden(),
  	  'Usuaris_UsuariID' => new sfWidgetFormJQueryAutocompleter(array('url'=>$BASE.'index.php/gestio/ajaxUsuaris'),array('style'=>'width:400px')),  	    	    	  
  	  'Cursos_idCursos'  => new sfWidgetFormInputHidden(),  	  
      'Estat'            => new sfWidgetFormInputHidden(),
      'Comentari'        => new sfWidgetFormInputHidden(),
      'DataInscripcio'   => new sfWidgetFormInputHidden(),
      'Pagat'        	 => new sfWidgetFormInputHidden(),  	  
      'tReduccio'        => new sfWidgetFormChoice(array('choices'=>MatriculesPeer::selectDescomptes())),
      'tPagament'        => new sfWidgetFormChoice(array('choices'=>MatriculesPeer::selectPagament())),
    ));

    $this->setValidators(array(      
      'idMatricules'     => new sfValidatorPropelChoice(array('model' => 'Matricules', 'column' => 'idMatricules', 'required' => false)),
      'Usuaris_UsuariID' => new sfValidatorCallback(array('callback'=>array('MatriculesUsuariForm','ComprovaUsuari'), 'arguments' => array('IDS'=>$this->getOption('IDS')) , 'required'=>true)),
      'Cursos_idCursos'  => new sfValidatorPropelChoice(array('required' => false,'model' => 'Cursos', 'column' => 'idCursos')),
      'Estat'            => new sfValidatorInteger(array('required' => false)),
      'Comentari'        => new sfValidatorString(array('required' => false)),
      'DataInscripcio'   => new sfValidatorDateTime(array('required' => false)),
      'Pagat'            => new sfValidatorNumber(array('required' => false)),
      'tReduccio'        => new sfValidatorInteger(),
      'tPagament'        => new sfValidatorInteger(),    
    ));

    $this->widgetSchema->setLabels(array(                  
      'Usuaris_UsuariID' => 'Usuari: ',
      'Cursos_idCursos'  => 'Curs: ',
      'Estat'            => 'Estat: ',
      'Comentari'        => 'Comentari: ',
      'DataInscripcio'   => 'Data d\'inscripció: ',
      'Descompte'        => 'Te descompte? ',
      'tReduccio'        => 'Te reducció? ',
      'tPagament'        => 'Com ha pagat? ',
    ));    
    
    $this->widgetSchema->setNameFormat('matricules_usuari[%s]');

    $this->setDefaults(array('Estat' => MatriculesPeer::EN_PROCES));
    
    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

  }

  public function getModelName()
  {
    return 'Matricules';
  }
  
  static public function ComprovaUsuari($A,$idU,$arguments)
  {
  	
  	//Si estem al període d'antics alumnes i no ho és, emetem error
  	if(!MatriculesPeer::isAnticAlumne($idU,$arguments['IDS']) && MatriculesPeer::isPeriodeAnticsAlumnes($arguments['IDS'])){
  		throw new sfValidatorError($A, "Error: L'usuari no ha cursat cap curs amb anterioritat");
  	}
  	  	  	  	
  	return $idU;  	
  }
  
}
