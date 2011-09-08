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
    $this->AUTENTIFICAT = $this->getUser()->isAuthenticated();                
    
    //Carrego la cerca
    $this->CERCA = $this->getUser()->getSessionPar('cerca');
    $C = $this->CERCA;            
    $this->DESPLEGABLES = array();            

    switch($this->accio){
        
        case 'cerca_activitat':
                                                                
                //Agafo els paràmetres si é sun post o bé si canvi de pàgina o sinó doncs cerca en blanc.                 
                if($request->getMethod() == 'POST') $C = $request->getParameter('cerca',array());                               
                $C['P'] = $request->getParameter('P',1);

                $this->getUser()->ParReqSesForm($request,'cerca',array());                                   
                $C['P'] = $request->getParameter('P',1);                     
                
                //Si em trobo el paràmetre SITE, impilca que he entrat per llistat d'entitats i vull veure tot el d'una.
                if($request->hasParameter('SITE')) $C['SITE'] = $request->getParameter('SITE');                                
                                                
                //Normalitzo tots els camps                    
                $C2 = $this->getCercaComplet($C);
                
                $RET = ActivitatsPeer::getActivitatsCercaHospici($C2);
                
                $this->ACTIVITATS_AMB_ENTRADES = EntradesReservaPeer::h_getEntradesUsuariArray($this->getUser()->getSessionPar('idU'));
                                
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
                $this->ACTIVITATS_AMB_ENTRADES = EntradesReservaPeer::h_getEntradesUsuariArray($this->getUser()->getSessionPar('idU'));                                            
                                
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

  /**
   * Omple el quadre de cerca amb tots els valors per defecte. 
   * */
  private function getCercaFormularisComplet($C)
  {    
    if(!isset($C['TEXT']))              $C['TEXT'] = "";
    if(!isset($C['SITE']))              $C['SITE'] = 0;        
    if(!isset($C['P']))                 $C['P'] = 1;
    return $C;
  }  


  public function executeLoginAjax(sfWebRequest $request){

    if($this->makeLogin($request->getParameter('login'),$request->getParameter('pass'))){
                $this->renderText('OK');        
    } else {    $this->renderText($request->getParameter('login'));  }    
            
    return sfView::NONE;
  }
    
  public function executeFeedbackAjax(sfWebRequest $request){

    $TEXT = $request->getParameter('nom');
    $TEXT .= '<br />'.$request->getParameter('mail');
    $TEXT .= '<br />'.$request->getParameter('comentari');
    $this->sendMail('informatica@casadecultura.org','informatica@casadecultura.org','Hospici :: Nou suggeriment',$TEXT);
    $this->renderText('OK');        
                        
    return sfView::NONE;
  }

  public function executeLogin(sfWebRequest $request)
  {
    $this->setLayout('hospici');    
    $this->setTemplate('index');                
  
    $login = ""; $pass  = "";
  
    if($request->hasParameter('id')){        
        $PAR = unserialize(Encript::Desencripta($request->getParameter('id')));
        $login = $PAR['login']; $pass = $PAR['pass'];   
    } else {
        $login = $request->getParameter('login');
        $pass  = $request->getParameter('pass');
    }
    
    if($this->makeLogin($login,$pass)){
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
            $OU = $this->FUSUARI->getObject();
            $this->makeLogin($OU->getDni(),$OU->getPasswd());                        
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
    
    $this->setLayout('hospici');
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
                    $this->MISSATGE1 = "OK";                                                 
                endif;                                                       
            endif;
            $this->SECCIO = 'USUARI';
        break;
            
        //Usuari que compra o reserva una entrada
        case 'compra_entrada':
            //Des de l'Hospici només es pot reservar una entrada. Més endavant s'haurà d'abonar l'import.
            $RS = $request->getParameter('entrades');
            $OER = EntradesReservaPeer::initialize()->getObject();
            $OA = ActivitatsPeer::retrieveByPK($RS['idA']);
            $idS = 0; if($OA instanceof Activitats) $idS = $OA->getSiteid();
            $this->MISSATGE2 = 'OK';
            try{ 
            //Si no existeix una compra per aquest usuari, la fem, altrament, no fem res.
            if(!EntradesReservaPeer::ExisteixenEntradesComprades($this->IDU,$RS['idA'])):
                //Falta mirar si hi ha entrades disponibles. 
                $OER->setUsuariid($this->IDU);
                $OER->setActivitatsid($RS['idA']);
                $OER->setQuantes($RS['num']);
                $OER->setData(date('Y-m-d H:i',time()));
                $OER->setEstat(EntradesReservaPeer::CONFIRMADA);
                $OER->setActiu(true);
                $OER->setSiteid($idS);
                $OER->save();
                UsuarisPeer::addSite($this->IDU,$idS);
            else: 
                $this->MISSATGE2 = 'ENTRADA_REPE';
            endif;            
            } catch(Exception $e){ $this->MISSATGE2 = 'ERROR';  }
                                
            $this->SECCIO = 'COMPRA_ENTRADA';
                                                
        break;
        
        //Usuari que anul·la una entrada prèviament reservada
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
        
        //Nova matrícula a un curs
        case 'nova_matricula':
            
            //Capturem el codi del curs i el codi del descompte
            $idC = $request->getParameter('idC');
            $idD = $request->getParameter('idD');
            $OC = CursosPeer::retrieveByPK($idC);

            //Si el curs és correcte
            if($OC instanceof Cursos)
            {

                //Generem la matícula en procés.                                                                                
                $OM = MatriculesPeer::saveNewMatricula($this->IDU,$idC,0,'Matrícula hospici',$idD);            
                $this->SECCIO = 'MATRICULA';
                                            
                if($OM instanceof Matricules)
                {            
                    
                    if($OM->getEstat() == MatriculesPeer::EN_ESPERA)
                    {
                        //El curs en qüestió ja està ple. Mostrem el llistat però el missatge de "en espera"
                        $this->MISSATGE3 = 'ESPERA';
                    }
                    elseif($OM->getEstat() == MatriculesPeer::EN_PROCES)
                    {
                        //La matrícula s'ha de cobrar amb targeta, només.
                        try 
                        {   
                            
                            //Carreguem les dades de l'usuari que està fent la matrícula  
                            $OU = UsuarisPeer::retrieveByPK($this->IDU);
    
                            //Carreguem el TPV
                            $this->TPV = MatriculesPeer::getTPV(
                                                    CursosPeer::CalculaPreu( $idC, $idD, $OC->getSiteId() ), 
                                                    $OU->getNomComplet() , 
                                                    $OM->getIdmatricules() , 
                                                    $this->IDS , true );
                            
                        } catch (Exception $e) { $this->MISSATGE3 = 'KO'; /* Faltarà enviar un missatge de mail */  }
                        
                        $this->URL = OptionsPeer::getString('TPV_URL',$OC->getSiteId());
                        $this->setLayout('blanc');
                        $this->setTemplate('pagament');
                                                                    
                    }
                    else
                    {
                        //Tot correcte. Mostrem el llistat de matrícules i el missatge que ha anat bé. 
                        $this->MISSATGE3 = "OK";
                    }
                }            
                else
                { 
                    if($OM == 1) $this->MISSATGE3 = "JA_EXISTEIX";
                    else $this->MISSATGE3 = "KO";
                }             
            }
            else
            {
                $this->MISSATGE3 = "CURS_NO_EXISTEIX";
            }
        break;

        //S'ha matriculat correctament i TPV ok
        case 'matricula_OK':
                $this->MISSATGE3 = "OK";
                $this->SECCIO   = 'MATRICULA';                
            break;
            
        //No s'ha matriculat correctament o error a TPV
        case 'matricula_KO':
                $this->MISSATGE3 = "KO";
                $this->SECCIO   = 'MATRICULA';
            break;
            
        //Gestió del que retorna el TPV
        case 'GET_TPV':
        
                //Comprovem que vingui la crida per POST i que la resposta sigui 0000. Tot OK. 
                //if( $request->getParameter('Ds_Response') == '0000' )
                if( $request->isMethod() == 'POST' && $request->getParameter('Ds_Response') == '0000' )                                
                {
                    
                    $idM = $request->getParameter('Ds_MerchantData',null);
                    
                    $OM     = MatriculesPeer::retrieveByPK($idM);
                    
                    
                    if($OM instanceof Matricules)
                    {                                                
                        
                        $from   = OptionsPeer::getString('MAIL_FROM',$OM->getSiteId());
                        
                        //Un cop sabem que la matrícula existeix, comprovem la signatura i si és correcta, marquem com a pagat.
                        if( MatriculesPeer::valTPV( $request->getParameter('Ds_Amount') , $request->getParameter('Ds_Order') , $request->getParameter('Ds_MerchantCode') , $request->getParameter('Ds_Currency') , $request->getParameter('Ds_Response') , $request->getParameter('Ds_Signature'), OptionsPeer::getString('TPV_PASSWORD',$OM->getSiteid() )))
                        {
                                                                                    
                            $MailMat    = MatriculesPeer::MailMatricula($OM,$OM->getSiteid());
                            $subject    = 'Hospici :: Nova matrícula';
                            
                            $OM->setEstat(MatriculesPeer::ACCEPTAT_PAGAT);
                            $OM->setTpvOperacio($request->getParameter('Ds_AuthorisationCode'));
                            $OM->setTpvOrder($request->getParameter('Ds_Order'));
                            $OM->save();                            
                            
                            $this->sendMail($from,$OM->getUsuaris()->getEmail(),$subject,$MailMat);
                            $this->sendMail($from,'informatica@casadecultura.org',$subject,$MailMat);
                                            
                        } else {

                 			$this->sendMail($from,'informatica@casadecultura.org','HASH ERRONI',$idM);
                            
                        }
                                                    
                    } else {
                        
                        $this->sendMail('informatica@casadecultura.org','informatica@casadecultura.org','CODI MATRÍCULA ERRONI',$idM);
                        
                    }
                                        
                }
                                
            break;

        //Mostra totes les reserves que s'han fet
        case 'llista_reserves':
            $this->SECCIO = 'RESERVA';            
            $this->MISSATGE4 = $request->getParameter('estat',null);
        break;

        //Editem una reserva prèviament feta
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
        
        //Creem una nova reserva, i mostrem el formulari
        case 'nova_reserva':        
            $idE = $request->getParameter('idE');
            $OE = EspaisPeer::retrieveByPK($idE);
            $this->SECCIO = 'RESERVA';
            
            if($OE instanceof Espais){
                $this->FReserva = ReservaespaisPeer::initializeHospici(null,$OE->getSiteid(),$OE->getEspaiid(),$this->getUser()->getSessionPar('idU'));                                                
            } else {
                $this->MISSATGE4 = "ERROR_ESPAI";                
            }
        break;  
                                        
        //Guardem la nova reserva
        case 'save_nova_reserva':
            
            $RP = $request->getParameter('reservaespais');
            $idU = $this->getUser()->getSessionPar('idU');
            $this->SECCIO = 'RESERVA';
            $this->FReserva = ReservaespaisPeer::initializeHospici(null,$RP['site_id'],null,$idU);
            $this->FReserva->bind($RP);
                        
            if($this->FReserva->isValid()){
                //Guardem la reserva
                $this->FReserva->save();
                
                //Enviem mails per informar que s'ha fet una nova reserva d'espais a secretaria
                $from = OptionsPeer::getString('MAIL_FROM',$RP['site_id']);
                $to   = OptionsPeer::getString('MAIL_SECRETARIA',$RP['site_id']);
                $sub  = "Hospici | Nova reserva d'espai";
                $miss = "S'ha sol·licitat una nova reserva d'espai amb el codi {$RP['ReservaEspaiID']}";
                $this->sendMail($from, $to, $sub, $miss);
                
                //Vinculem l'usuari amb el site corresponent
                UsuarisPeer::addSite($idU,$RP['site_id']);
                                                        
                $this->redirect('@hospici_llista_reserves?estat=OK');
            } else {
                $this->MISSATGE4 = 'ERROR_SAVE';            
            }                
                            
        break;

        //Alta d'un nou formulari
        case 'alta_formulari':
                        
            $RP = $request->getParameter('formulari');
            $idU = $this->getUser()->getSessionPar('idU');            
            $OF = FormularisRespostesPeer::initialize($RP['idF'],$idU,serialize($RP));
            $OF->save();                                                    
            
            //Enviem mails per informar que s'ha fet una nova reserva d'espais a secretaria
            $from = OptionsPeer::getString('MAIL_FROM',$OF->getSiteid());
            $to   = OptionsPeer::getString('MAIL_ADMIN',$OF->getSiteid());
            $sub  = "Hospici | Nou formulari enviat";
            $miss = "S'ha enviat la següent informació amb una reserva d'espai.<br/><br />Dades:<br /><br /> ";
            foreach($RP as $K=>$V):
                $miss .= $K.': '.$V.'<br/>';
            endforeach;
            $this->sendMail($from, $to, $sub, $miss);
            $this->sendMail($from, 'giroscopi@casadecultura.org', $sub, $miss);
            
            //Vinculem l'usuari amb el site corresponent
            UsuarisPeer::addSite($idU,$OF->getSiteid());
            
            $this->MISSATGE6 = 'ALTA_OK';
            $this->SECCIO = "FORMULARIS";
                            
        break;
        
        //Capturem el que ens arriba del mail de condicions. 
        case 'condicions':
            
            $this->SECCIO = 'RESERVA';
            $RP = $request->getParameter('reservaespais');
            $idU = $this->getUser()->getSessionPar('idU');
            $OR = ReservaespaisPeer::retrieveByPK($request->getParameter('idR'));
            if($OR instanceof Reservaespais):
                if($request->hasParameter('B_ACCEPTO')){
                    $OR->setEstat(ReservaespaisPeer::ACCEPTADA);
                    $OR->setDataacceptaciocondicions(date('Y-m-d',time()));
                    $OR->save();            
                    $this->redirect('@hospici_llista_reserves?estat=RESERVA_ACCEPTADA');
                } elseif($request->hasParameter('B_NO_ACCEPTO')){
                    $OR->setEstat(ReservaespaisPeer::ANULADA);
                    $OR->setDataacceptaciocondicions(date('Y-m-d',time()));
                    $OR->save();
                    $this->redirect('@hospici_llista_reserves?estat=RESERVA_ANULADA');
                } else {
                    $this->redirect('@hospici_llista_reserves?estat=ERROR_TECNIC');
                }                
            else:                 
                $this->redirect('@hospici_llista_reserves?estat=ERROR_TECNIC');
            endif; 
                                                                                
        break;               
                                                                       
    }
            
    //Si ja hi hem fet operacions... carreguem l'actual, sinó en fem un de nou.
    if(isset($FU) && $FU instanceof UsuarisForm) $this->FUsuari = $FU;
    else $this->FUsuari = UsuarisPeer::initialize($this->IDU,$this->IDS,false,true);
    
    $this->LMatricules = MatriculesPeer::h_getMatriculesUsuari($this->IDU);
    $this->LReserves = ReservaespaisPeer::h_getReservesUsuaris($this->IDU,$this->IDS);    
    $this->LEntrades = EntradesReservaPeer::getEntradesUsuari($this->IDU);
    $this->LFormularis = FormularisRespostesPeer::getFormularisUsuari($this->IDU);    
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
    $C = $this->CERCA;    
    $this->DESPLEGABLES = array();
    $this->AUTH = $this->getUser()->isAuthenticated();
    $this->CURSOS_MATRICULATS = MatriculesPeer::h_getMatriculesCursosUsuariArray($this->getUser()->getSessionPar('idU'));  
    
    if($this->accio == 'cerca_cursos' || $this->accio == 'inici'):
        
        //Agafo els paràmetres si é sun post o bé si canvi de pàgina o sinó doncs cerca en blanc.         
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
                                                                
        //Guardem a sessió la cerca "actual"
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


  /**
   * hospiciActions::executeFormularis()
   * 
   * Part de mostra dels formularis a l'hospici
   * 
   * @param mixed $request
   * @return void
   */
  public function executeForms(sfWebRequest $request)
  {    
   
    $this->setLayout('hospici');
    $this->setTemplate('indexFormularis');
    $this->accio = $request->getParameter('accio','index');        
    
    //Carrego la cerca
    $this->CERCA = $this->getUser()->getSessionPar('cerca',array());    
    $this->DESPLEGABLES = array();
    $this->AUTH = $this->getUser()->isAuthenticated();
    $this->IDU  = $this->getUser()->getSessionPar('idU');      
    
    if($this->accio == 'cerca_formularis' || $this->accio == 'inici'):
        
        //Agafo els paràmetres                
        if($request->getMethod() == 'POST') $C = $request->getParameter('cerca',array());
        $C['P'] = $request->getParameter('P',1);
        
        //Si em trobo el paràmetre SITE, implica que he entrat per llistat d'entitats i vull veure els formularis.
        if($request->hasParameter('SITE')) $C['SITE'] = $request->getParameter('SITE');
        
        $C2 = $this->getCercaFormularisComplet($C);

        //La cerca hauria de tornar el llistat dels formularis que compleixen.        
        $this->LLISTAT_FORMS = FormularisPeer::getFormularisCercaHospici($C2);                                                 
        $this->DESPLEGABLES['SELECT_ENTITATS'] = FormularisPeer::getEntitatsHospici($C2);
                                                                
        //Guardem a sessió la cerca "actual"        
        $this->CERCA = $C2;    
        $this->getUser()->setSessionPar('cerca',$this->CERCA);
                             
        $this->MODE = 'CERCA';            
            
    elseif($this->accio == 'detall_formularis'):
                                    
                $idU = $this->getUser()->getSessionPar('idU',0);
                $idF = $request->getParameter('idF',0);
                $this->FORM = FormularisPeer::retrieveByPK($idF);
                $this->FORM_TEXT = FormularisRespostesPeer::getFormulariDetall( $idU , $idF );                                                                                                                                                        
                $this->MODE = 'DETALL';
                                
    endif;                          
                                                                                 
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


    /**
     * Gestió de formularis a través de mail     
     * */
   public function executeFormularis(sfWebRequest $request)
   {               
    
        $this->setLayout('gestio');
        $this->DEFAULT = false;
        $this->IDU = $this->getUser()->getSessionPar('idU');
        $this->IDS = $this->getUser()->getSessionPar('idS');
    
        //Entren crides i es mostra una reposta en web si ha anat bé o no.        
        $PARAMETRES = Encript::Desencripta($request->getParameter('PAR'));
        $PAR = unserialize($PARAMETRES);
        switch($PAR['formulari']){
        
            //Paràmetres [id = IDReservaEspais]
            //Només es podrà si l'estat actual és ESPERA_ACCEPTACIÓ_CONDICIONS
            case 'Reserva_Espais_Mail_Accepta_Condicions':                    
                    $OR = ReservaespaisPeer::retrieveByPK($PAR['id']);
                    
                    //Fem un login i després acceptem les condicions
                    $OU = UsuarisPeer::retrieveByPK($OR->getUsuarisUsuariid());
                    $this->makeLogin($OU->getDNI(),$OU->getPasswd());
                    
                    if($OR instanceof Reservaespais && $OR->setAcceptada()):
                        $this->redirect('@hospici_llista_reserves?estat=RESERVA_ACCEPTADA');                        
                    else:
                        $this->redirect('@hospici_llista_reserves?estat=ERROR_TECNIC');                        
                    endif;                                          
                                       
                    UsuarisPeer::addSite( $OR->getUsuarisUsuariid() , $OR->getSiteid() );    
                break;
                
            //Des del mail la persona no accepta i rebutja les condicions. 
            case 'Reserva_Espais_Mail_Rebutja_Condicions':                    
                    $OR = ReservaespaisPeer::retrieveByPK($PAR['id']);

                    //Fem un login i després acceptem les condicions
                    $OU = UsuarisPeer::retrieveByPK($OR->getUsuarisUsuariid());
                    $this->makeLogin($OU->getDNI(),$OU->getPasswd());
                                        
                    if($OR instanceof Reservaespais && $OR->setRebutjada()):        
                        $this->redirect('@hospici_llista_reserves?estat=RESERVA_ANULADA');                        
                    else:
                        $this->redirect('@hospici_llista_reserves?estat=ERROR_TECNIC');                        
                    endif;
                    
                    UsuarisPeer::addSite( $OR->getUsuarisUsuariid() , $OR->getSiteid() );
                break;
            default:
            break;
        }    
   }



}