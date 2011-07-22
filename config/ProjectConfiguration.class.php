<?php

//require_once '/Users/manel/Desktop/htdocs/trunk/lib/symfony/1.2.8/lib/autoload/sfCoreAutoload.class.php';
//require_once '/home/albert/Escriptori/htdocs/lib/symfony/1.2.8/lib/autoload/sfCoreAutoload.class.php';
//require_once 'C:\Documents and Settings\casacultura\Escritorio\htdocs\trunk\lib\symfony\1.2.8\lib\autoload\sfCoreAutoload.class.php';
//require_once 'C:\Documents and Settings\casacultura\Escritorio\htdocs\trunk\lib\symfony\1.3.5\lib\autoload\sfCoreAutoload.class.php';
require_once 'C:\Documents and Settings\casacultura\Escritorio\htdocs\trunk\lib\symfony\1.4.5\lib\autoload\sfCoreAutoload.class.php';
//require_once '/home/informatica/www/llibreries/symfony/1.4.5/lib/autoload/sfCoreAutoload.class.php';

sfCoreAutoload::register();

class ProjectConfiguration extends sfProjectConfiguration
{
  public function setup()
  {
    // for compatibility / remove and enable only the plugins you want
    $this->enableAllPluginsExcept(array('sfDoctrinePlugin'));
    $this->dispatcher->connect('debug.web.load_panels', array($this, 'configureWebDebugToolbar'));
    
  }
    
   public function configureWebDebugToolbar(sfEvent $event)
  {
    $webDebugToolbar = $event->getSubject();    
    $webDebugToolbar->setPanel('Propel', new sfWebDebugPanelPropel($webDebugToolbar));
  }
  
}
