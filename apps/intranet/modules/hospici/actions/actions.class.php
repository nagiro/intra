<?php

/**
 * hospici actions.
 *
 * @package    intranet
 * @subpackage hospici
 * @author     Albert Joh� i Mart�
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class hospiciActions extends sfActions
{
 /**
  * Executes index action
  *
  * @param sfRequest $request A request object
  */
  public function executeIndex(sfWebRequest $request)
  {    
    $this->setLayout('hospici');
    $this->accio = $request->getParameter('accio','index');
    $this->AUTENTIFICAT = $this->getUser()->getSessionPar('idU');        
    
    //Carrego la cerca
    $this->CERCA = $this->getUser()->getSessionPar('cerca');    

    switch($this->accio){        
        case 'cerca_activitat':
        
                //Agafo el paràmetre
                $C = $request->getParameter('cerca',array());
                                
                //Normalitzo tots els camps                    
                $C2 = $this->getCercaComplet($C);        
                                                        
                //Guardem a sessió la cerca "actual"        
                $this->CERCA = $C2;
                $this->getUser()->setSessionPar('cerca',$this->CERCA);                                                                                                                                                    
                                                
                $this->LLISTAT_ACTIVITATS = ActivitatsPeer::getActivitatsHospici($this->CERCA['TEXT'],$this->CERCA['SITE'],$this->CERCA['POBLE'][0],$this->CERCA['CATEGORIA'][0],$this->CERCA['DATA'][0],$this->CERCA['DATAR'],$this->CERCA['P']);
                $this->MODE = 'CERCA';
            break;
    
        case 'detall_activitat':                
                $this->CERCA = $this->getUser()->getSessionPar('cerca');
                $this->ACTIVITAT = ActivitatsPeer::retrieveByPK($request->getParameter('idA'));                                            
                //Sempre s'haurà de comprar una entrada per un horari.                          
                if(!($this->ACTIVITAT instanceof Activitats)) $this->ACTIVITAT = new Activitats();
                $this->LHO = $this->ACTIVITAT->getEntradesHoraris();                
                
                $this->MODE = 'DETALL';
            break;
        
        //Arribem per primer cop al web o no entrem per cap url interessant
        default:
                                
            //Inicialitzem la cerca i la guardem a memòria
            $this->CERCA = $this->getCercaComplet(null);
            $this->getUser()->setSessionPar('cerca',$this->CERCA);
            $this->MODE = 'INICIAL';
    }                                        
    
  }
   
  /**
   * Omple el quadre de cerca amb tots els valors per defecte. 
   * */
  private function getCercaComplet($C)
  {    
    if(!isset($C['TEXT']))              $C['TEXT'] = "";
    if(!isset($C['SITE']))              $C['SITE'] = array(0=>0);
    if(!isset($C['POBLE']))             $C['POBLE'] = array(0=>0);
    if(!isset($C['CATEGORIA']))         $C['CATEGORIA'] = array(0=>0);
    if(!isset($C['DATA']))              $C['DATA'] = array(0=>0);
    if(!isset($C['DATAR']))             $C['DATAR'] = array('DI'=>time(), 'DF'=>time());
    if(!isset($C['P']))                 $C['P'] = 1;
    return $C;
  }  
  
  /**
   * Realitza totes les consultes AJAX D'activitats
   * */    
  public function executeAjaxACT(sfWebRequest $request)
  {
    $accio = $request->getParameter('ACCIO');
    
    switch($accio){
        case 'POB_ON':
                $C = new Criteria();
                $text = $request->getParameter('TEXT');
                $idP = $request->getParameter('ON');    
                $sel = $request->getParameter('SEL');
                $R = ActivitatsPeer::selectCategoriesActivitats($idP[0],$text);
            break;
        case 'POB_QUAN':
             	$C = new Criteria();
                $idP = $request->getParameter('ON');
                $idC = $request->getParameter('CAT');    
                $sel = $request->getParameter('SEL');
                $text = $request->getParameter('TEXT');
                $R = ActivitatsPeer::selectDatesActivitats($idP[0],$idC[0],$text,null);
            break;
        case 'ENT_QUAN':
             	$C = new Criteria();
                $idE = $request->getParameter('ENT');        
                $sel = $request->getParameter('SEL');
                $text = $request->getParameter('TEXT');
                $R = ActivitatsPeer::selectDatesActivitats(null,null,$text,$idE[0]);            
            break;        
    }
    
    $RET = "";
    foreach($R as $K=>$E){
        $SELECTED = ($sel == $K)?"SELECTED":"";        
        $RET .= '<option '.$SELECTED.' value="'.$K.'">'.$E.'</option>';        
    }        
    return $this->renderText($RET);
   
  
  }  


  /**
   * Realitza totes les consultes AJAX D'activitats
   * */    
  public function executeAjaxCUR(sfWebRequest $request)
  {
    $accio = $request->getParameter('ACCIO');
    
    switch($accio){
        case 'POB_ON':
                $C = new Criteria();
                $text = $request->getParameter('TEXT');
                $idP = $request->getParameter('ON');    
                $sel = $request->getParameter('SEL');
                $R = CursosPeer::selectCategoriesCursos($idP[0],$text);
            break;
        case 'POB_QUAN':
             	$C = new Criteria();
                $idP = $request->getParameter('ON');
                $idC = $request->getParameter('CAT');    
                $sel = $request->getParameter('SEL');
                $text = $request->getParameter('TEXT');
                $R = CursosPeer::selectDatesCursos($idP[0],$idC[0],$text,null);
            break;
        case 'ENT_QUAN':
             	$C = new Criteria();
                $idE = $request->getParameter('ENT');        
                $sel = $request->getParameter('SEL');
                $text = $request->getParameter('TEXT');
                $R = CursosPeer::selectDatesCursos(null,null,$text,$idE[0]);            
            break;        
    }
    
    $RET = "";
    foreach($R as $K=>$E){
        $SELECTED = ($sel == $K)?"SELECTED":"";        
        $RET .= '<option '.$SELECTED.' value="'.$K.'">'.$E.'</option>';        
    }        
    return $this->renderText($RET);
   
  
  }  


  public function executeLogin(sfWebRequest $request)
  {
    $this->setLayout('hospici');    
    $this->setTemplate('index');
    
    $OU = UsuarisPeer::getUserLogin($request->getParameter('login'),$request->getParameter('pass'),null);    
    if($OU instanceof Usuaris):
        $this->getUser()->setAuthenticated(true);        
        $this->getUser()->setSessionPar('idU',$OU->getUsuariid());
        $this->getUser()->setSessionPar('username',$OU->getNomComplet());
        $this->getUser()->setSessionPar('compres',array());
        $this->redirect('@hospici_usuaris');        
    else: 
        $this->getUser()->setAuthenticated(false);
        $this->getUser()->setSessionPar('idU',0);
        $this->getUser()->setSessionPar('username','');
        $this->getUser()->setSessionPar('compres',array());
        $this->redirect('@hospici_cercador_activitats');        
    endif;
            
  }  

  public function executeRemember(sfWebRequest $request)
  {
    
    $this->setLayout('hospici');
    
    if($request->isMethod('POST')):        
        //L'usuari he enviat el seu DNI i se li ha d'enviar la contrassenya
        $RS = $request->getParameter('remember');        
        $this->FREMEMBER = new RememberForm();
        $this->FREMEMBER->bind($RS);
        if($this->FREMEMBER->isValid()):
            $OU = UsuarisPeer::cercaDNI($this->FREMEMBER->getValue('DNI'));
            $BODY = OptionsPeer::getString('MAIL_REMEMBER',SitesPeer::HOSPICI_ID);
            $BODY = str_replace('{{PASSWORD}}',$OU->getPasswd(),$BODY);
            $this->ENVIAT = $this->sendMail(OptionsPeer::getString('MAIL_FROM',$this->IDS),$OU->getEmail(),' Hospici :: Recordatori de contrasenya ',$BODY);
            $this->ENVIAT = $this->sendMail(OptionsPeer::getString('MAIL_FROM',$this->IDS),'informatica@casadecultura.org', '[Hospici :: RECORDATORI '.$OU->getUsuariid().']',$BODY);
            if(!$this->ENVIAT):
                $this->SECCIO = "ERROR_ENVIAMENT";
            else:
                $this->SECCIO = 'ENVIADA';                         			            
            endif;                   
            
        else: 
            $this->SECCIO = 'ERROR_DNI_VALIDACIO';
        endif;        
            
    else:     
        $this->FREMEMBER = new RememberForm();    
        $this->SECCIO = 'INICI';        
    endif;
    
  }

  public function executeAlta(sfWebRequest $request)
  {
    $this->setLayout('hospici');
    
    if($request->isMethod('POST')):        
        //L'usuari, l'he de donar d'alta de l'Hospici com a mínim, que serà un SITE = 0.
        //Primer mirarem si l'usuari ja existeix
        $RS = $request->getParameter('usuaris');
        $this->FUSUARI = UsuarisPeer::initialize(null,0,false,true);
        $this->FUSUARI->bind($RS);
        if($this->FUSUARI->isValid()):
            $this->FUSUARI->save();
            $this->SECCIO = 'GUARDAT';
        else: 
            $this->SECCIO = 'INICI';        
        endif;                    
    else:     
        $this->FUSUARI = UsuarisPeer::initialize(null,0,false,true);
        $this->SECCIO = 'INICI';    
    endif;
    
  }
  
  public function executeUsuaris(sfWebRequest $request)
  {
    $accio = $request->getParameter('accio','inici');
    $this->IDU = $this->getUser()->getSessionPar('idU');
    $this->IDS = SitesPeer::HOSPICI_ID;
    $this->SECCIO = "";
    
    switch($accio){
        
        case 'inici':
            $this->SECCIO = 'INICI';
            break;
        
        //Modificació de les dades de l'usuari.
        case 'update':
            $RS = $request->getParameter('usuaris');
            if($RS['UsuariID'] == $this->IDU):
                $FU = UsuarisPeer::initialize($this->IDU,$this->IDS,false,true);
                $FU->bind($RS);                
                if($FU->isValid()):
                    $FU->save();
                    $this->MISSATGE = "OK";                             
                endif;                                                       
            endif;
        case 'compra_entrada':
            //Des de l'Hospici només es pot reservar una entrada. Més endavant s'haurà d'abonar l'import.
            $RS = $request->getParameter('entrades');
            $OER = EntradesReservaPeer::initialize()->getObject();
            //Si no existeix una compra per aquest usuari, la fem, altrament, no fem res.
            if(!EntradesReservaPeer::ExisteixenEntradesComprades($this->IDU,$RS['idH'])):
                $OER->setUsuariid($this->IDU);
                $OER->setHorarisid($RS['idH']);
                $OER->setQuantes($RS['num']);
                $OER->setData(date('Y-m-d H:i',time()));
                $OER->setEstat(0);
                $OER->setActiu(true);
                $OER->save();
            endif;
                                    
            $this->SECCIO = 'COMPRA_ENTRADA';
                                                
        break;
        
        case 'anula_entrada':            
            $RS = $request->getParameter('idER');
            $OER = EntradesReservaPeer::retrieveByPK($RS);
            $idu = $OER->getUsuariid();
            $act = $OER->getActiu();
            
            if($idu == $this->IDU && $act):
                $OER->setEstat(EntradesReservaPeer::ANULADA);
                $OER->save();
            endif;                        
                                    
            $this->SECCIO = 'COMPRA_ENTRADA';
                                                
        break;        
        
    }
    
    $this->setLayout('hospici');
    
    //Si ja hi hem fet operacions... carreguem l'actual, sinó en fem un de nou.
    if(isset($FU) && $FU instanceof UsuarisForm) $this->FUsuari = $FU;
    else $this->FUsuari = UsuarisPeer::initialize($this->IDU,$this->IDS,false,true);
    
    $this->LMatricules = MatriculesPeer::h_getMatriculesUsuari($this->IDU);
    $this->LReserves = ReservaespaisPeer::h_getReservesUsuaris($this->IDU,$this->IDS);
    $this->LEntrades = EntradesReservaPeer::getEntradesUsuari($this->IDU);
    // $this->LMissatges = MissatgesPeer::getMissatgesUsuari();    
        
  }  
  
  /**
   * hospiciActions::executeCursos()
   * 
   * Part de mostra de cursos a l'hospici
   * 
   * @param mixed $request
   * @return void
   */
  public function executeCursos(sfWebRequest $request)
  {    
    $this->setLayout('hospici');
    $this->setTemplate('indexCursos');
    $this->accio = $request->getParameter('accio','index');        
    
    //Carrego la cerca
    $this->CERCA = $this->getUser()->getSessionPar('cerca');    

    switch($this->accio){        
        case 'cerca_cursos':
               
                //Agafo el paràmetre
                $C = $request->getParameter('cerca',array());
                                
                //Normalitzo tots els camps                    
                $C2 = $this->getCercaComplet($C);        
                                                        
                //Guardem a sessió la cerca "actual"        
                $this->CERCA = $C2;
                $this->getUser()->setSessionPar('cerca',$this->CERCA);                                                                                                                                                    
                                                
                $this->LLISTAT_CURSOS = CursosPeer::getCursosHospici($this->CERCA['TEXT'],$this->CERCA['SITE'],$this->CERCA['POBLE'][0],$this->CERCA['CATEGORIA'][0],$this->CERCA['DATA'][0],$this->CERCA['DATAR'],$this->CERCA['P']);
                
                $this->MODE = 'CERCA';
                
            break;
    
        case 'detall_curs':
        
                $this->CURS = CursosPeer::retrieveByPK($request->getParameter('idC'));
                $this->MODE = 'DETALL';
                
            break;
        
        //Arribem per primer cop al web o no entrem per cap url interessant
        case 'inici':            
            //Inicialitzem la cerca i la guardem a memòria
            $this->CERCA = $this->getCercaComplet(null);
            $this->getUser()->setSessionPar('cerca',$this->CERCA);
            $this->MODE = 'INICIAL';
    }                                        
    
  }

  /**
   * hospiciActions::executeEspais()
   * 
   * Part de mostra dels espais per reservar a l'hospici
   * 
   * @param mixed $request
   * @return void
   */
  public function executeEspais(sfWebRequest $request)
  {    
  
    $this->setLayout('hospici');
    $this->setTemplate('indexReservaEspais');
    $this->accio = $request->getParameter('accio','index');        
    
    //Carrego la cerca
    $this->CERCA = $this->getUser()->getSessionPar('cerca');    

    switch($this->accio){        
        case 'cerca_cursos':
               
                //Agafo el paràmetre
                $C = $request->getParameter('cerca',array());
                                
                //Normalitzo tots els camps                    
                $C2 = $this->getCercaComplet($C);        
                                                        
                //Guardem a sessió la cerca "actual"        
                $this->CERCA = $C2;
                $this->getUser()->setSessionPar('cerca',$this->CERCA);                                                                                                                                                    
                                                
                $this->LLISTAT_CURSOS = CursosPeer::getCursosHospici($this->CERCA['TEXT'],$this->CERCA['SITE'],$this->CERCA['POBLE'][0],$this->CERCA['CATEGORIA'][0],$this->CERCA['DATA'][0],$this->CERCA['DATAR'],$this->CERCA['P']);
                
                $this->MODE = 'CERCA';
                
            break;
    
        case 'detall_curs':
        
                $this->CURS = CursosPeer::retrieveByPK($request->getParameter('idC'));
                $this->MODE = 'DETALL';
                
            break;
        
        //Arribem per primer cop al web o no entrem per cap url interessant
        default:            
            //Inicialitzem la cerca i la guardem a memòria
            $this->CERCA = $this->getCercaComplet(null);
            $this->getUser()->setSessionPar('cerca',$this->CERCA);
            $this->MODE = 'INICIAL';
    }                                        
    
  }

  static public function getDatesCercadorHospici($idData,$aDates){
  
    //Hem de buscar segons data.    
    switch($idData){
        case "0": //El mateix dia 
            $datai = date('Y-m-d',time());
            $dataf = date('Y-m-d',time());            
            break;
        case "1": //El cap de setmana
            $t = time();            
            while(6 <> date('w',$t)) $t = strtotime(date("Y-m-d", $t) . "+1 day");
            $datai = date('Y-m-d',$t);                        
            while(0 <> date('w',$t)) $t = strtotime(date("Y-m-d", $t) . "+1 day");
            $dataf = date('Y-m-d',$t);
            break;
        case "2": //Aquest mes
            $datai = date('Y-m-d',strtotime(date("Y-m-d", time())));
            $dataf = date('Y-m-d',strtotime(date("Y-m-d", time()) . "+1 month"));            
            break;
        case "3": //El mes que ve
            $datai = date('Y-m-d',strtotime(date("Y-m-d", time()) . "+1 month"));
            $dataf = date('Y-m-d',strtotime(date("Y-m-d", time()) . "+2 month"));            
            break;
        case "4": //Dos mesos
            $datai = date('Y-m-d',strtotime(date("Y-m-d", time()) . "+2 month"));
            $dataf = date('Y-m-d',strtotime(date("Y-m-d", time()) . "+3 month"));            
            break;
        case "5": //Rang
            $datai = preg_replace("/([0-9]{2})[\/|\-]([0-9]{2})[\/|\-]([0-9]{4})/","\$3-\$2-\$1",$aDates['DI']);
            $dataf = preg_replace("/([0-9]{2})[\/|\-]([0-9]{2})[\/|\-]([0-9]{4})/","\$3-\$2-\$1",$aDates['DF']);
            break;
        default:
            $datai = date('Y-m-d',strtotime(date("Y-m-d", time())));
            $dataf = date('Y-m-d',strtotime(date("Y-m-d", time()) . "+3 month"));
            break;                                            
    }    

    return array('datai'=>$datai,'dataf'=>$dataf);

  }

  private function sendMail($from,$to,$subject,$body = "",$files = array())
  {
   	
    $swift_message = $this->getMailer()->compose($from,$to,$subject,$body);    
    foreach($files as $F):
    	$swift_message->attach(Swift_Attachment::fromPath($F['tmp_name']));
    endforeach;    
    $swift_message->setBody($body,'text/html');    
    return $this->getMailer()->send($swift_message);
		
  }


}
