<?php

/**
 * Matricules form.
 *
 * @package    intranet
 * @subpackage form
 * @author     Albert Johé i Martí
 * @version    SVN: $Id: sfPropelFormTemplate.php 10377 2008-07-21 07:10:32Z dwhittle $
 */
class MatriculesForm extends sfFormPropel
{
  public function setup()
  {  	
  	
  	$this->setWidgets(array(
      'idMatricules'     => new sfWidgetFormInputHidden(),
  	  'Usuaris_UsuariID' => new sfWidgetFormInputHidden(),  	  
  	  'Cursos_idCursos'  => new sfWidgetFormChoice(array('choices'=>CursosPeer::getSelectCursos())),
      'Estat'            => new sfWidgetFormChoice(array('choices'=>MatriculesPeer::getEstatsSelect())),
      'DataInscripcio'   => new sfWidgetFormDateTime(array('date'=>array('format'=>'%day%/%month%/%year%'))),
      'Pagat'        	 => new sfWidgetFormInputText(),
      'tReduccio'        => new sfWidgetFormChoice(array('choices'=>MatriculesPeer::selectDescomptes())),
      'tPagament'        => new sfWidgetFormChoice(array('choices'=>MatriculesPeer::selectPagament())),
  	  'Comentari'        => new sfWidgetFormTextarea(),
    ));

    $this->setValidators(array(      
      'idMatricules'     => new sfValidatorPropelChoice(array('model' => 'Matricules', 'column' => 'idMatricules', 'required' => false)),
      'Usuaris_UsuariID' => new sfValidatorPropelChoice(array('model' => 'Usuaris', 'column' => 'UsuariID')),
      'Cursos_idCursos'  => new sfValidatorPropelChoice(array('model' => 'Cursos', 'column' => 'idCursos')),
      'Estat'            => new sfValidatorInteger(array('required' => false)),
      'Comentari'        => new sfValidatorString(array('required' => false)),
      'DataInscripcio'   => new sfValidatorDateTime(array('required' => false)),
      'Pagat'            => new sfValidatorNumber(array('required' => false)),
      'tReduccio'        => new sfValidatorInteger(),
      'tPagament'        => new sfValidatorInteger(),    
    ));
    
    $this->widgetSchema->setLabels(array(                        
      'Cursos_idCursos'  => 'Curs: ',
      'Estat'            => 'Estat: ',
      'Comentari'        => 'Comentari: ',
      'DataInscripcio'   => 'Data d\'inscripciÃ³: ',
      'Descompte'        => 'Te descompte? ',
      'tReduccio'        => 'Te reducciÃ³? ',
      'tPagament'        => 'Com ha pagat? ',
    ));    
    
    $this->widgetSchema->setNameFormat('matricules[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

  }

  public function getModelName()
  {
    return 'Matricules';
  }

}
