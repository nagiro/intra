<?php

/*
 * This file is part of the symfony package.
 * (c) Fabien Potencier <fabien.potencier@symfony-project.com>
 * 
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

/**
 * sfWidgetFormTextareaTinyMCE represents a Tiny MCE widget.
 *
 * You must include the Tiny MCE JavaScript file by yourself.
 *
 * @package    symfony
 * @subpackage widget
 * @author     Fabien Potencier <fabien.potencier@symfony-project.com>
 * @version    SVN: $Id: sfWidgetFormTextareaTinyMCE.class.php 17192 2009-04-10 07:58:29Z fabien $
 */
class sfWidgetFormTextareaTinyMCE extends sfWidgetFormTextarea
{
  /**
   * Constructor.
   *
   * Available options:
   *
   *  * theme:  The Tiny MCE theme
   *  * width:  Width
   *  * height: Height
   *  * config: The javascript configuration
   *
   * @param array $options     An array of options
   * @param array $attributes  An array of default HTML attributes
   *
   * @see sfWidgetForm
   */
  protected function configure($options = array(), $attributes = array())
  {
    $this->addOption('theme', 'advanced');
    $this->addOption('width');
    $this->addOption('height');
    $this->addOption('config', '');
  }

  /**
   * @param  string $name        The element name
   * @param  string $value       The value selected in this widget
   * @param  array  $attributes  An array of HTML attributes to be merged with the default HTML attributes
   * @param  array  $errors      An array of errors for the field
   *
   * @return string An HTML tag string
   *
   * @see sfWidgetForm
   */
  public function render($name, $value = null, $attributes = array(), $errors = array())
  {
    $textarea = parent::render($name, $value, $attributes, $errors);

    $js = sprintf(<<<EOF
<script type="text/javascript">
  tinyMCE.init({
    mode:                              "exact",
    elements:                          "%s",
    plugins:                           "media,table,paste,fullscreen",        
    extended_valid_elements : "input[name|size|type|value|onclick],iframe[height|width|src]",
    theme:                             "%s",
    language:                          "ca",
    %s
    %s
    paste_auto_cleanup_on_paste:       true,
    paste_strip_class_attributes:      "all",
    theme_advanced_toolbar_location:   "top",
    theme_advanced_toolbar_align:      "left",
    theme_advanced_statusbar_location: "bottom",
    theme_advanced_resizing:           true,
	theme_advanced_blockformats :      "p,div,h1,h2,h3,h4,h5,h6,blockquote,dt,dd,code,samp",
	theme_advanced_buttons1 :          "fullscreen,bold,italic,underline,separator,justifycenter,justifyfull,bullist,indent,separator,table,separator,undo,redo,separator,link,unlink,image,media,separator,formatselect,separator,code",
	theme_advanced_buttons2 :          "",
	theme_advanced_buttons3 :          "",
	file_browser_callback:             'ajaxfilemanager',
	relative_urls:  				   false,	    
    %s
  })
  function ajaxfilemanager(field_name, url, type, win) {
      var ajaxfilemanagerurl = "../../../../js/tiny_mce/plugins/ajaxfilemanager/ajaxfilemanager.php";
      switch (type) {
        case "image":
          break;
        case "media":
          break;
        case "flash": 
          break;
        case "file":
          break;
        default:
          return false;
      }
            tinyMCE.activeEditor.windowManager.open({
                url: "../../../../js/tiny_mce/plugins/ajaxfilemanager/ajaxfilemanager.php",
                width: 782,
                height: 440,
                inline : "yes",
                close_previous : "no"
            },{
                window : win,
                input : field_name
            });
    }
  ;
</script>
EOF
    ,
      $this->generateId($name),
      $this->getOption('theme'),
      $this->getOption('width')  ? sprintf('width:                             "%spx",', $this->getOption('width')) : '',
      $this->getOption('height') ? sprintf('height:                            "%spx",', $this->getOption('height')) : '',
      $this->getOption('config') ? ",\n".$this->getOption('config') : ''
    );

    return $textarea.$js;
  }
}
