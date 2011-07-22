<?php
/**
 * sfTinyDoc
 *
 * This class extends tinyDoc as a symfony plugin's.
 *
 * This class needs : tinyDoc class
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @package    tinyDoc
 * @subpackage sfTinyDoc
 * @author     Olivier Loynet <olivierloynet@gmail.com>
 * @version    SVN: $Id: sfTinyDoc.class.php 1 2009-04-22 07:00:00Z oloynet $
 */
class sfTinyDoc extends tinyDoc
{
  /**
   * Constructor.
   *
   * Extended for symfony to read the config from the entry 'sf_tiny_doc_plugin' in app.yml
   * <code>
   *   all:
   *     sf_tiny_doc_plugin:
   *       zip_method:    shell
   *       zip_bin:       zip
   *       unzip_bin:     unzip
   *       process_dir:   %SF_WEB_DIR%/tmp
   * </code>
   */
  function __construct()
  {
    // get default setting from symfony 'app.yml'
    $this->setZipMethod(  sfConfig::get('app_sf_tiny_doc_plugin_zip_method'   , 'shell'));
    $this->setZipBinary(  sfConfig::get('app_sf_tiny_doc_plugin_zip_bin'      , 'zip'));
    $this->setUnzipBinary(sfConfig::get('app_sf_tiny_doc_plugin_unzip_bin'    , 'unzip'));
    $this->setProcessDir( sfConfig::get('app_sf_tiny_doc_plugin_process_dir'  , sfConfig::get('sf_web_dir').DIRECTORY_SEPARATOR.'tmp'));
  }


  /**
   * Override the method to set the document source filename to be like symfony templates filename
   *
   * Available options:
   *  - dirname:     The dirname   of the document source file (symfony module templates directory by default)
   *  - basename:    The basename  of the document source file (symfony action name by default)
   *  - extension:   The extension of the document source file (odt by default)
   *
   * @param mixed $options  The sourcePathname or an array of options
   */
  public function setSourcePathname($options = array())
  {
    if (is_array($options))
    {
      $context = sfContext::getInstance();
      if (!isset($options['dirname']))
      {
        $options['dirname'] = $context->getModuleDirectory().DIRECTORY_SEPARATOR.'templates';
      }
      if (!isset($options['basename']))
      {
        $options['basename'] = $context->getActionName();
      }
      if (!isset($options['extension']))
      {
        $options['extension'] = $this->getDefaultExtension();
      }

      $sourcePathname = $options['dirname'].DIRECTORY_SEPARATOR.$options['basename'].'Success'.'.'.$options['extension'];
    }
    else
    {
      $sourcePathname = $options;
    }

    parent::setSourcePathname($sourcePathname);
  }


  /**
   * Override the method to get the filename to download as the symfony current action by default
   *
   * @return string The download filename
   */
  public function getDownloadFilename($options = array())
  {
    $context = sfContext::getInstance();

    return $context->getActionName().'.'.$this->getExtension();
  }


  /**
   * Override the method to send the symfony response
   */
  public function sendResponse($options = array())
  {
    $response = sfContext::getInstance()->getResponse();
    $response->setContentType($this->getMimetype());
    $response->setHttpHeader('Content-Disposition', 'attachment; filename="'.$this->getDownloadFilename().'"');
    $response->setHttpHeader('Content-Length', $this->getSize());
    $response->setContent($this->getContent());
    $response->sendHttpHeaders();
    $response->sendContent();
  }

}