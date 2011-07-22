<?php

/**
 * Usuaris form.
 *
 * @package    intranet
 * @subpackage form
 * @author     Albert Joh� i Mart�
 * @version    SVN: $Id: sfPropelFormTemplate.php 10377 2008-07-21 07:10:32Z dwhittle $
 */
class UsuarisForm extends sfFormPropel
{
  public function setup()
  {
    
    //Carrego el nivell de l'usuari a la taula,. Si l'estic veient per força n'he de tenir.
    $OUS = UsuarisSitesPeer::initialize($this->getObject()->getUsuariId(),$this->getObject()->getSiteId(),false)->getObject();
    if($OUS->isNew()): $NIVELL = NivellsPeer::REGISTRAT;
    else: $NIVELL = $OUS->getNivellId();
    endif;     
    
    $this->setWidgets(array(
      'UsuariID'          => new sfWidgetFormInputHidden(),
      'Nivells_idNivells' => new sfWidgetFormChoice( array( 'choices'=> NivellsPeer::getSelect() ) , array() ),
      'DNI'               => new sfWidgetFormInputText(array(),array('style'=>'width:200px')),
      'Passwd'            => new sfWidgetFormInputPassword(array('always_render_empty'=>false),array('always_render_empty'=>false, 'style'=>'width:200px')),
      'Nom'               => new sfWidgetFormInputText(array(),array('style'=>'width:200px')),
      'Cog1'              => new sfWidgetFormInputText(array(),array('style'=>'width:200px')),
      'Cog2'              => new sfWidgetFormInputText(array(),array('style'=>'width:200px')),
      'Email'             => new sfWidgetFormInputText(array(),array('style'=>'width:200px')),
      'Adreca'            => new sfWidgetFormInputText(array(),array('style'=>'width:200px')),
      'CodiPostal'        => new sfWidgetFormInputText(array(),array('style'=>'width:200px')),
      'Poblacio'          => new sfWidgetFormPropelChoice(array('model' => 'Poblacions', 'add_empty' => true)),
      'Poblaciotext'      => new sfWidgetFormInputText(array(),array('style'=>'width:200px')),
      'Telefon'           => new sfWidgetFormInputText(array(),array('style'=>'width:200px')),
      'Mobil'             => new sfWidgetFormInputText(array(),array('style'=>'width:200px')),
      'Entitat'           => new sfWidgetFormInputText(array(),array('style'=>'width:200px')),
      'Habilitat'         => new sfWidgetFormChoice(array('choices'=>array(1=>'Sí',0=>'No')),array()),
      'Actualitzacio'     => new sfWidgetFormInputHidden(array(),array()),
      'site_id'           => new sfWidgetFormInputHidden(array(),array()),
    ));
    
    $this->setDefault('Nivells_idNivells',$NIVELL);
    
    $C = new Criteria();
    $C->addAscendingOrderByColumn(PoblacionsPeer::NOM);
    
    $this->setValidators(array(
      'UsuariID'          => new sfValidatorPropelChoice(array('model' => 'Usuaris', 'column' => 'UsuariID', 'required' => false)),
      'Nivells_idNivells' => new sfValidatorPropelChoice(array('model' => 'Nivells', 'column' => 'idNivells')),
      'Passwd'            => new sfValidatorString(array('max_length' => 20, 'required' => true)),
      'Nom'               => new sfValidatorString(array('required' => true)),
      'Cog1'              => new sfValidatorString(array('required' => true)),
      'Cog2'              => new sfValidatorString(array('required' => false)),
      'Email'             => new sfValidatorEmail(array('required' => true)),
      'Adreca'            => new sfValidatorString(array('required' => false)),
      'CodiPostal'        => new sfValidatorInteger(array('required' => false)),
      'Poblacio'          => new sfValidatorPropelChoice(array('model' => 'Poblacions', 'criteria' => $C , 'column' => 'idPoblacio', 'required' => false)),
      'Poblaciotext'      => new sfValidatorString(array('required' => false)),
      'Telefon'           => new sfValidatorString(array('required' => false)),
      'Mobil'             => new sfValidatorString(array('required' => false)),
      'Entitat'           => new sfValidatorString(array('required' => false)),
      'Habilitat'         => new sfValidatorBoolean(array('required' => false)),
      'Actualitzacio'     => new sfValidatorDate(array('required'=>false),array()),
      'site_id'           => new sfValidatorPass(array(),array()),
    ));

    $this->setValidator('DNI', new sfValidatorCallback(array('callback'=>array('UsuarisForm','ComprovaDNI'), 'arguments' => array('idU'=>$this->getObject()->getUsuariId()) , 'required'=>true)));
    
    $this->widgetSchema->setLabels(array(          
      'Nivells_idNivells' => 'Nivell: ',
      'DNI'               => 'DNI: ',
      'Passwd'            => 'Contrasenya: ',
      'Nom'               => 'Nom: ',
      'Cog1'              => 'Primer cognom: ',
      'Cog2'              => 'Segon cognom: ',
      'Email'             => 'Correu electrònic: ',
      'Adreca'            => 'Adreça postal: ',
      'CodiPostal'        => 'Codi postal: ',
      'Poblacio'          => 'Població: ',
      'Poblaciotext'      => 'Població: ',
      'Telefon'           => 'Telèfon: ',
      'Mobil'             => 'Mòbil: ',
      'Entitat'           => 'Entitat: ',
      'Habilitat'         => 'Habilitat: ',        
    ));    
    
    $this->widgetSchema->setNameFormat('usuaris[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

  }

  public function getModelName()
  {    
    return 'Usuaris';    
  }

  public function save($conn = null)
  {
    
    //Les dades de l'usuari que es mantenen són sempre les noves. Guardem la data d'actualització i avall.'
    $this->updateObject();
    $OU = $this->getObject();
    $OU->setActualitzacio(date('Y-m-d',time())); //Guardem la data d'actualització.'
    $OU->save();                    
        
    //Mirem si l'usuari està relacionat amb el SITE
    $OUS = UsuarisSitesPeer::initialize($OU->getUsuariId() , $OU->getSiteId())->getObject();    
    $OUS->setNivellid($this->getValue('Nivells_idNivells'));
    $OUS->save();
    
  }

  static public function ComprovaDNI($A,$valor,$arguments)
  {
  	  	    
  	$DNI = trim($valor);
  	
  	if(self::valida_nif_cif_nie($DNI) <= 0) throw new sfValidatorError($A, "Error: El DNI és incorrecte.<br /> Recorda escriure'l amb el format 99999999A.");
  	
  	$OUsuari = UsuarisPeer::cercaDNI($DNI);    
  	if($OUsuari instanceof Usuaris && $OUsuari->getUsuariid() != $arguments['idU']) throw new sfValidatorError($A, "Error: El DNI ja existeix. Si us plau envii un missatge a informatica@casadecultura.org per a més informació. ");
  	return $valor;
  	  	
  } 
  
  
  static public function valida_nif_cif_nie($cif) {
	//Copyright ©2005-2008 David Vidal Serra. Bajo licencia GNU GPL.
	//Este software viene SIN NINGUN TIPO DE GARANTIA; para saber mas detalles
	//puede consultar la licencia en http://www.gnu.org/licenses/gpl.txt
	//Esto es software libre, y puede ser usado y redistribuirdo de acuerdo
	//con la condicion de que el autor jamas sera responsable de su uso.
	//Returns: 1 = NIF ok, 2 = CIF ok, 3 = NIE ok, -1 = NIF bad, -2 = CIF bad, -3 = NIE bad, 0 = ??? bad
	   $cif = strtoupper($cif);
	   for ($i = 0; $i < 9; $i ++)
	      $num[$i] = substr($cif, $i, 1);
	//si no tiene un formato valido devuelve error
	   if (!preg_match('((^[A-Z]{1}[0-9]{7}[A-Z0-9]{1}$|^[T]{1}[A-Z0-9]{8}$)|^[0-9]{8}[A-Z]{1}$)', $cif))
	      return 0;
	//comprobacion de NIFs estandar
	   if (preg_match('(^[0-9]{8}[A-Z]{1}$)', $cif))
	      if ($num[8] == substr('TRWAGMYFPDXBNJZSQVHLCKE', substr($cif, 0, 8) % 23, 1))
	         return 1;
	      else
	         return -1;
	//algoritmo para comprobacion de codigos tipo CIF
	   $suma = $num[2] + $num[4] + $num[6];
	   for ($i = 1; $i < 8; $i += 2)
	      $suma += substr((2 * $num[$i]),0,1) + substr((2 * $num[$i]),1,1);
	   $n = 10 - substr($suma, strlen($suma) - 1, 1);
	//comprobacion de NIFs especiales (se calculan como CIFs o como NIFs)
	   if (preg_match('(^[KLM]{1})', $cif))
	      if ($num[8] == chr(64 + $n) || $num[8] == substr('TRWAGMYFPDXBNJZSQVHLCKE', substr($cif, 1, 8) % 23, 1))
	         return 1;
	      else
	         return -1;
	//comprobacion de CIFs
	   if (preg_match('(^[ABCDEFGHJNPQRSUVW]{1})', $cif))
	      if ($num[8] == chr(64 + $n) || $num[8] == substr($n, strlen($n) - 1, 1))
	         return 2;
	      else
	         return -2;
	//comprobacion de NIEs
	   //T
	   if (preg_match('(^[T]{1})', $cif))
	      if ($num[8] == preg_match('^[T]{1}[A-Z0-9]{8}$', $cif))
	         return 3;
	      else
	         return -3;
	   //XYZ
	   if (preg_match('(^[XYZ]{1})', $cif))
	      if ($num[8] == substr('TRWAGMYFPDXBNJZSQVHLCKE', substr(str_replace(array('X','Y','Z'), array('0','1','2'), $cif), 0, 8) % 23, 1))
	         return 3;
	      else
	         return -3;
	//si todavia no se ha verificado devuelve error
	   return 0;
	}
    
}
