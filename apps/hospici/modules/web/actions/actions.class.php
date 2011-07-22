<?php

/**
 * hospici actions.
 *
 * @package    intranet
 * @subpackage hospici
 * @author     Albert Johé i Martí
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class webActions extends sfActions
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
    $this->DESPLEGABLES = array();            

    switch($this->accio){        
        case 'cerca_activitat':
        
                //Agafo el paràmetre                
                if($request->getMethod() == 'POST') $C = $this->getUser()->ParReqSesForm($request,'cerca',array());
                $C['P'] = $request->getParameter('P',1);                                
                
                //Si em trobo el paràmetre SITE, impilca que he entrat per llistat d'entitats i vull veure tot el d'una.
                if($request->hasParameter('SITE')) $C['SITE'] = $request->getParameter('SITE');                                
                                                
                //Normalitzo tots els camps                    
                $C2 = $this->getCercaComplet($C);
                
                $RET = ActivitatsPeer::getActivitatsCercaHospici($C2);
                $this->LLISTAT_ACTIVITATS = $RET['PAGER'];        
                $LACTIVITATS = $RET['LACTIVITATS'];                
                $this->DESPLEGABLES['SELECT_POBLACIONS'] = ActivitatsPeer::getPoblacionsActivitatsHospici($LACTIVITATS);
                $this->DESPLEGABLES['SELECT_ENTITATS']   = ActivitatsPeer::getEntitatsActivitatsHospici($LACTIVITATS);
                $this->DESPLEGABLES['SELECT_CATEGORIES'] = ActivitatsPeer::getCategoriaActivitatsHospici($LACTIVITATS);
                                                        
                //Guardem a sessió la cerca "actual"        
                $this->CERCA = $C2;
                $this->getUser()->setSessionPar('cerca',$this->CERCA);                                                                                                                                                    
                                                                
                $this->MODE = 'CERCA';
            break;
    
        case 'detall_activitat':                
                $this->CERCA = $this->getUser()->getSessionPar('cerca');
                $this->ACTIVITAT = ActivitatsPeer::retrieveByPK($request->getParameter('idA'));                                            
                //Sempre s'haurÃ  de comprar una entrada per un horari.                          
                if(!($this->ACTIVITAT instanceof Activitats)) $this->ACTIVITAT = new Activitats();
                $this->LHO = $this->ACTIVITAT->getEntradesHoraris();                
                
                $this->MODE = 'DETALL';
            break;
        
        //Arribem per primer cop al web o no entrem per cap url interessant
        default:
                                
            //Inicialitzem la cerca i la guardem a memÃ²ria
            $this->CERCA = $this->getCercaComplet(null);
            $this->getUser()->setSessionPar('cerca',$this->CERCA);
            $this->MODE = 'INICIAL';
    }                                        
    
  }
   

  /**
   * Omple el quadre de cerca amb tots els valors per defecte. 
   * */
  private function getCercaCursosComplet($C)
  {    
    if(!isset($C['TEXT']))              $C['TEXT'] = "";
    if(!isset($C['SITE']))              $C['SITE'] = 0;
    if(!isset($C['POBLE']))             $C['POBLE'] = 0;
    if(!isset($C['CATEGORIA']))         $C['CATEGORIA'] = 0;
    if(!isset($C['DATA']))              $C['DATA'] = 0;    
    if(!isset($C['P']))                 $C['P'] = 1;
    return $C;
  }  

  /**
   * Omple el quadre de cerca amb tots els valors per defecte. 
   * */
  private function getCercaEspaisComplet($C)
  {    
    if(!isset($C['TEXT']))              $C['TEXT'] = "";
    if(!isset($C['SITE']))              $C['SITE'] = 0;
    if(!isset($C['POBLE']))             $C['POBLE'] = 0;
    if(!isset($C['CATEGORIA']))         $C['CATEGORIA'] = 0;
    if(!isset($C['DATAI']))             $C['DATAI'] = 0;    
    if(!isset($C['DATAF']))             $C['DATAF'] = 0;
    if(!isset($C['P']))                 $C['P'] = 1;
    return $C;
  }  


  /**
   * Omple el quadre de cerca amb tots els valors per defecte. 
   * */
  private function getCercaComplet($C)
  {    
    if(!isset($C['TEXT']))              $C['TEXT'] = "";
    if(!isset($C['SITE']))              $C['SITE'] = 0;
    if(!isset($C['POBLE']))             $C['POBLE'] = 0;
    if(!isset($C['CATEGORIA']))         $C['CATEGORIA'] = 0;
    if(!isset($C['DATAI']))             $C['DATAI'] = date('d/m/Y',time());
    if(!isset($C['DATAF']))             $C['DATAF'] = date('d/m/Y',mktime(0,0,0,date('m',time())+1,date('d',time()),date('Y',time())));
    if(!isset($C['P']))                 $C['P'] = 1;
    return $C;
  }   

  public function executeLoginAjax(sfWebRequest $request){

    if($this->makeLogin($request->getParameter('login'),$request->getParameter('pass'))){
                $this->renderText('OK');        
    } else {    $this->renderText($request->getParameter('login'));  }    
            
    return sfView::NONE;
  }

  public function executeLogin(sfWebRequest $request)
  {
    $this->setLayout('hospici');    
    $this->setTemplate('index');
    
    if($this->makeLogin($request->getParameter('login'),$request->getParameter('pass'))){
                $this->redirect('@hospici_usuaris');        
    } else {    $this->redirect('@hospici_cercador_activitats');  }
            
  }  

  private function makeLogin($user,$pass){

    $OU = UsuarisPeer::getUserLogin($user,$pass,null);
    
    $OK = false;    
    if($OU instanceof Usuaris):
        $this->getUser()->setAuthenticated(true);        
        $this->getUser()->setSessionPar('idU',$OU->getUsuariid());
        $this->getUser()->setSessionPar('username',$OU->getNomComplet());
        $this->getUser()->setSessionPar('compres',array());        
        $OK = true;        
    else: 
        $this->getUser()->setAuthenticated(false);
        $this->getUser()->setSessionPar('idU',0);
        $this->getUser()->setSessionPar('username','');
        $this->getUser()->setSessionPar('compres',array());
        $OK = false;        
    endif;

    return $OK;
    
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
            $this->SECCIO = 'USUARI';
        break;
            
        case 'compra_entrada':
            //Des de l'Hospici nomÃ©s es pot reservar una entrada. MÃ©s endavant s'haurÃ  d'abonar l'import.
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
        
        case 'nova_matricula':
            
            $idC = $request->getParameter('idC');            
            $OM = MatriculesPeer::saveNewMatricula($this->IDU,$idC,0);
            $this->SECCIO = 'MATRICULA';            
            if($OM instanceof Matricules):
                $this->MISSATGE = "OK";
                if($OM->getEstat() == MatriculesPeer::EN_ESPERA):
                    $this->MISSATGE = 'ESPERA';
                endif;
            else: 
                if($OM == 1) $this->MISSATGE = "JA_EXISTEIX";
                else $this->MISSATGE = "KO";
            endif;             
        break;

        case 'llista_reserves':
            $this->SECCIO = 'RESERVA';
        break;

        case 'edita_reserva':
            $this->SECCIO = "RESERVA";
            $OR = ReservaespaisPeer::retrieveByPK($request->getParameter('idR'));
            if($OR instanceof Reservaespais):
                $this->FReserva = new HospiciReservesForm($OR,array('IDS'=>$OR->getSiteid()));
                $this->OPCIONS = 'VISUALITZA'; 
            else: 
                $this->redirect('@hospici_llista_reserves');
            endif;
            
        break;
        
        case 'nova_reserva':        
            $idE = $request->getParameter('idE');
            $OE = EspaisPeer::retrieveByPK($idE);
            $this->SECCIO = 'RESERVA';
            
            if($OE instanceof Espais){
                $this->FReserva = ReservaespaisPeer::initializeHospici(null,$OE->getSiteid(),$OE->getEspaiid(),$this->getUser()->getSessionPar('idU'));                                
            } else {
                $this->MISSATGE = "ERROR_ESPAI";                
            }
        break;  
    
        case 'save_nova_reserva':
            
            $RP = $request->getParameter('reservaespais');
            $this->SECCIO = 'RESERVA';
            $this->FReserva = ReservaespaisPeer::initializeHospici(null,$RP['site_id'],null,$this->getUser()->getSessionPar('idU'));
            $this->FReserva->bind($RP);
                        
            if($this->FReserva->isValid()){
                $this->FReserva->save();       
                $this->MISSATGE = "OK";
                $this->redirect('@hospici_llista_reserves');             
            } else {
                $this->MISSATGE = 'ERROR_SAVE';            
            }                
                            
        break;               
                       
                         
    }
    
    $this->setLayout('hospici');
    
    //Si ja hi hem fet operacions... carreguem l'actual, sinÃ³ en fem un de nou.
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
    $this->CERCA = $this->getUser()->getSessionPar('cerca',array());    
    $this->DESPLEGABLES = array();
    $this->AUTH = $this->getUser()->isAuthenticated();
    $this->CURSOS_MATRICULATS = MatriculesPeer::h_getMatriculesCursosUsuariArray($this->getUser()->getSessionPar('idU'));  
    
    if($this->accio == 'cerca_cursos' || $this->accio == 'inici'):
        
        //Agafo els paràmetres
        if($request->getMethod() == 'POST') $C = $request->getParameter('cerca',array());
        $C['P'] = $request->getParameter('P',1);

        //Si em trobo el paràmetre SITE, impilca que he entrat per llistat d'entitats i vull veure tot el d'una.
        if($request->hasParameter('SITE')) $C['SITE'] = $request->getParameter('SITE');
        
        $C2 = $this->getCercaCursosComplet($C);
                                
        //Faig la cerca dels cursos de l'Hospici i ho retorno amb valors
        //La cerca hauria de tornar els cursos, segons els paràmetres i a més els llistats amb els valors.    
        $RET = CursosPeer::getCursosCercaHospici($C2['TEXT'],$C2['SITE'],$C2['POBLE'],$C2['CATEGORIA'],$C2['DATA'],$C2['P']);        
        $this->LLISTAT_CURSOS = $RET['PAGER'];        
        $LCURSOS = $RET['LCURSOS'];
        $this->DESPLEGABLES['SELECT_POBLACIONS'] = CursosPeer::getPoblacionsCursosHospici($LCURSOS);
        $this->DESPLEGABLES['SELECT_ENTITATS']   = CursosPeer::getEntitatCursosHospici($LCURSOS);
        $this->DESPLEGABLES['SELECT_CATEGORIES'] = CursosPeer::getCategoriaCursosHospici($LCURSOS);
        $this->DESPLEGABLES['SELECT_DATES']      = CursosPeer::getDatesCursosHospici($LCURSOS);                
                                                                
        //Guardem a sessiÃ³ la cerca "actual"        
        $this->CERCA = $C2;    
        $this->getUser()->setSessionPar('cerca',$this->CERCA);
                             
        $this->MODE = 'CERCA';            
            
    elseif($this->accio == 'detall_curs'):
                    
                $this->CURS = CursosPeer::retrieveByPK($request->getParameter('idC'));
                $this->MODE = 'DETALL';                                        
    endif;                                        
    
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
    $this->CERCA = $this->getUser()->getSessionPar('cerca',array());    
    $this->DESPLEGABLES = array();
    $this->AUTH = $this->getUser()->isAuthenticated();      
    
    if($this->accio == 'cerca_espais' || $this->accio == 'inici'):
        
        //Agafo els paràmetres                
        if($request->getMethod() == 'POST') $C = $request->getParameter('cerca',array());
        $C['P'] = $request->getParameter('P',1);
        
        //Si em trobo el paràmetre SITE, impilca que he entrat per llistat d'entitats i vull veure tot el d'una.
        if($request->hasParameter('SITE')) $C['SITE'] = $request->getParameter('SITE');
        
        $C2 = $this->getCercaEspaisComplet($C);
                                        
        //Faig la cerca dels cursos de l'Hospici i ho retorno amb valors
        //La cerca hauria de tornar els cursos, segons els paràmetres i a més els llistats amb els valors.        
        $this->LLISTAT_ESPAIS = EspaisPeer::getEspaisCercaHospici($C2);                                 
        $this->DESPLEGABLES['SELECT_POBLACIONS'] = EspaisPeer::getPoblacionsHospici($C2);        
        $this->DESPLEGABLES['SELECT_ENTITATS']   = EspaisPeer::getEntitatsHospici($C2);
        $this->DESPLEGABLES['SELECT_CATEGORIES'] = EspaisPeer::getCategoriesHospici($C2);                        
                                                                
        //Guardem a sessió la cerca "actual"        
        $this->CERCA = $C2;    
        $this->getUser()->setSessionPar('cerca',$this->CERCA);
                             
        $this->MODE = 'CERCA';            
            
    elseif($this->accio == 'detall_espai'):
                    
                $this->ESPAI = EspaisPeer::retrieveByPK($request->getParameter('idE'));
                $this->DATA = $request->getParameter('data',time());                
                $month = date('m',$this->DATA); $year = date('Y',$this->DATA);                                
                $this->OCUPACIO = EspaisPeer::getEstadistiquesEspais(
                                                                        array($request->getParameter('idE')), 
                                                                        $this->ESPAI->getSiteId(), 
                                                                        $month,
                                                                        $year);
                                                                                        
                $d = mktime(0,0,0,$month+1,1,$year);
                $month = date('m',$d); $year = date('Y',$d);
                $this->OCUPACIO2 = EspaisPeer::getEstadistiquesEspais(
                                                                        array($request->getParameter('idE')), 
                                                                        $this->ESPAI->getSiteId(), 
                                                                        $month,
                                                                        $year);                                                                        
                $this->MODE = 'DETALL';                                        
    endif;                                        
    
  }

  /**
   * hospiciActions::executeEntitats()
   * 
   * Part de mostra dels espais per reservar a l'hospici
   * 
   * @param mixed $request
   * @return void
   */
  public function executeEntitats(sfWebRequest $request)
  {    
  
    $this->setLayout('hospici');
    $this->setTemplate('indexEntitats');
    $this->accio = $request->getParameter('accio','index');        
    
    //Carrego la cerca
    $this->CERCA = $this->getUser()->getSessionPar('cerca',array());
    $this->DESPLEGABLES = array();
    $this->AUTH = $this->getUser()->isAuthenticated();      
            
    //Comença la cerca *************************************************
            
    //Agafo els paràmetres
    $C = $request->getParameter('cerca',array());
    $C2 = $this->getCercaEspaisComplet($C);
                                    
    //Faig la cerca dels cursos de l'Hospici i ho retorno amb valors
    //La cerca hauria de tornar els cursos, segons els paràmetres i a més els llistats amb els valors.        
    $this->LLISTAT_ENTITATS = SitesPeer::getEntitatsCercaHospici($C2);                                 
    $this->DESPLEGABLES['SELECT_POBLACIONS'] = SitesPeer::getPoblacionsCercaHospici($C2);                
    $this->DESPLEGABLES['SELECT_CATEGORIES'] = SitesPeer::getCategoriesCercaHospici($C2);                        
                                                            
    //Guardem a sessió la cerca "actual"        
    $this->CERCA = $C2;    
    $this->getUser()->setSessionPar('cerca',$this->CERCA);
                         
    $this->MODE = 'CERCA';            
                                                                                 
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
