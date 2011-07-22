<?php

/*
 * This file is part of the symfony package.
 * (c) Fabien Potencier <fabien.potencier@symfony-project.com>
 * 
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

/**
 * 
 *
 * @package    symfony
 * @subpackage widget
 * @author     Fabien Potencier <fabien.potencier@symfony-project.com>
 * @version    SVN: $Id: sfWidgetFormSchemaFormatterList.class.php 5995 2007-11-13 15:50:03Z fabien $
 */
class sfWidgetFormSchemaFormatterHorizontal extends sfWidgetFormSchemaFormatter
{
  protected
    $rowFormat       = '<div style="float:left; margin-top:3px; margin-left:3px;">%error%%field%%help%%hidden_fields%</div>',
    $errorRowFormat  = "%errors%",
    $helpFormat      = '<br />%help%',
    $decoratorFormat = '<div>%content%</div>';
}
