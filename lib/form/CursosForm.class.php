<?php

/**
 * Cursos form.
 *
 * @package    intranet
 * @subpackage form
 * @author     Albert Johé i Martí
 * @version    SVN: $Id: sfPropelFormTemplate.php 10377 2008-07-21 07:10:32Z dwhittle $
 */
class CursosForm extends sfFormPropel
{
  public function setup()
  {
    
    $this->WEB_IMATGE = 'images/cursos/'; 
  	$this->WEB_PDF    = 'images/cursos/';   
    $this->BASE       = sfConfig::get('sf_websysroot'); 
    
    $this->setWidgets(array(
      'idCursos'        => new sfWidgetFormInputHidden(),
      'Codi'            => new sfWidgetFormInputText(array(),array('style'=>'width:100px;')),
      'TitolCurs'       => new sfWidgetFormInputText(array(),array('style'=>'width:100%;')),
      'isActiu'         => new sfWidgetFormChoice(array('choices'=>array(1=>'Sí',0=>'No'))),
      'Places'          => new sfWidgetFormInputText(array(),array('style'=>'width:10%;')),      
      'Descripcio'      => new sfWidgetFormTextareaTinyMCE(array(),array()),
      'Preu'            => new sfWidgetFormInputText(array(),array('style'=>'width:10%;')),
      'Preur'           => new sfWidgetFormInputText(array(),array('style'=>'width:10%;')),
      'Horaris'         => new sfWidgetFormInputText(array(),array('style'=>'width:50%;')),
      'Categoria'       => new sfWidgetFormChoice(array('choices'=>CursosPeer::getSelectCategories())),      
      'OrdreSortida'    => new sfWidgetFormInputText(array(),array('style'=>'width:10%;')),      
      'DataInici'       => new sfWidgetFormJQueryDateMy(array('format'=>'%day%/%month%/%year%'),array()),
      'DataInMatricula' => new sfWidgetFormJQueryDateMy(array('format'=>'%day%/%month%/%year%'),array()),
      'DataFiMatricula' => new sfWidgetFormJQueryDateMy(array('format'=>'%day%/%month%/%year%'),array()),
      'site_id'         => new sfWidgetFormInputHidden(),
      'VisibleWEB'      => new sfWidgetFormChoice(array('choices'=>array(1=>'Sí',0=>'No'))),
      'actiu'           => new sfWidgetFormInputHidden(),
      'isEntrada'       => new sfWidgetFormChoice(array('choices'=>array(0=>'No',1=>'Només reserva',2=>'Matrícula i pagament amb targeta')),array()),
      'PDF'             => new sfWidgetFormInputFileEditableMy(array('file_src'=>'/'.$this->WEB_PDF.$this->getObject()->getPdf() , 'is_image'=>false,'with_delete'=>false)),
      'ADescomptes'     => new sfWidgetFormChoice(array('renderer_class'=>'sfWidgetFormSelectManyMy' , 'choices'=>MatriculesPeer::selectDescomptes() , 'multiple'=>true , 'expanded'=>true),array('class'=>'ul_espais')), 
    ));

    $this->setDefaults(array(
        'isEntrada'     => CursosPeer::HOSPICI_RESERVA,
        'VisibleWEB'    => 1,
        'isActiu'       => 1,        
    ));

    $this->setValidators(array(
      'idCursos'        => new sfValidatorPropelChoice(array('model' => 'Cursos', 'column' => 'idCursos', 'required' => false)),
      'TitolCurs'       => new sfValidatorString(array('required' => true)),
      'isActiu'         => new sfValidatorBoolean(array('required' => true)),
      'Places'          => new sfValidatorInteger(array('required' => true)),
      'Codi'            => new sfValidatorString(array('required' => true)),
      'Descripcio'      => new sfValidatorString(array('required' => true)),
      'Preu'            => new sfValidatorInteger(array('required' => true)),
      'Preur'           => new sfValidatorInteger(array('required' => true)),
      'Horaris'         => new sfValidatorString(array('required' => true)),
      'Categoria'       => new sfValidatorString(array('required' => true)),
      'OrdreSortida'    => new sfValidatorInteger(array('required' => false)),
      'DataInMatricula' => new sfValidatorDate(array('required' => true)),
      'DataFiMatricula' => new sfValidatorDate(array('required' => true)),
      'DataInici'       => new sfValidatorDate(array('required' => true)),
      'VisibleWEB'      => new sfValidatorInteger(array('required' => true)),
      'site_id'         => new sfValidatorInteger(array('min' => -128, 'max' => 127, 'required' => false)),
      'actiu'           => new sfValidatorInteger(array('min' => -128, 'max' => 127, 'required' => false)),
      'isEntrada'       => new sfValidatorInteger(array('required'=>true),array()),       
      'PDF'             => new sfValidatorFile(array('path'=>$this->BASE.$this->WEB_PDF , 'required' => false)),
      'ADescomptes'     => new sfValidatorString(array('required'=>false)),
    ));

    
    $this->widgetSchema->setLabels(array(      
      'TitolCurs'       => 'Títol del curs: ',
      'isActiu'         => 'Matrícula oberta? ',
      'Places'          => 'Núm de places: ',
      'Descripcio'      => 'Descripció: ',
      'Preu'            => 'Preu: ',
      'Preur'           => 'Preu reduït: ',
      'Horaris'         => 'Descripció d\'horaris: ',
      'Categoria'       => 'Categoria: ',
      'OrdreSortida'    => 'Ordre de sortida: ',
      'DataInici'       => 'Inici del curs: ',
      'DataInMatricula' => 'WEB: Inici matriculació: ',
      'DataFiMatricula' => 'WEB: Fi matriculació: ',
      'VisibleWEB'      => 'WEB: Visible a hospici?',
      'isEntrada'       => 'WEB: Reserva i pagament?',
      'PDF'             => 'WEB: Doc. pdf: ',
      'ADescomptes'      => 'WEB: Descompte possible? ',
    ));
    
    
    $this->widgetSchema->setNameFormat('cursos[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);
    
    $this->widgetSchema->setFormFormatterName('Span');
    
  }

  public function getModelName()
  {
    return 'Cursos';
  }

  public function save($conn = null)
  {

    //Actualitzem l'objecte
	$this->updateObject();
  	$OC = $this->getObject();
    //Guardem els descomptes  	  	  	  	  	
  	if(!is_null($this['ADescomptes']->getValue())) $OC->setAdescomptes(implode('@',$this['ADescomptes']->getValue()));  	  	
  	  	
  	$BASE = $this->BASE.$this->WEB_PDF;    
  	 	
  	if($OC instanceof Cursos):
  	  			    
	    $P = $OC->getPdf();
  		if(!empty($P) && file_exists($BASE.$P)):
  			$nom = $OC->getIdcursos().'.pdf';
		  	rename($BASE.$P,$BASE.$nom);
		    if( $P <> $nom ) unlink($BASE.$P);
		    $OC->setPdf($nom);
	    endif;
	endif;

  	$OC->save();

  }

}
