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
 * @version    SVN: $Id: sfWidgetFormSchemaFormatterTable.class.php 5995 2007-11-13 15:50:03Z fabien $
 */
class sfWidgetFormSchemaFormatterSpan extends sfWidgetFormSchemaFormatter
{
  protected  	
    $rowFormat       = '<div class="clear row fb"><span class="title row_title fb">%label%</span><span class="row_field fb">%error%%field%%help%%hidden_fields%</span></div>',
    $errorRowFormat  = "<span class=\"error row fb\">%errors%</span>",
    $helpFormat      = '<br />%help%',
    $decoratorFormat = "<div class=\"FORMULARI\">  %content%</div>";
}
