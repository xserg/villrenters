<?php
/**
 * PEAR_Installer_Role_Src
 *
 * PHP versions 4 and 5
 *
 * @category   pear
 * @package    PEAR
 * @author     Greg Beaver <cellog@php.net>
 * @copyright  1997-2009 The Authors
 * @license    http://opensource.org/licenses/bsd-license.php New BSD License
 * @version    CVS: $Id: Src.php 70 2011-04-11 07:15:31Z xxserg@gmail.com $
 * @link       http://pear.php.net/package/PEAR
 * @since      File available since Release 1.4.0a1
 */

/**
 * @category   pear
 * @package    PEAR
 * @author     Greg Beaver <cellog@php.net>
 * @copyright  1997-2009 The Authors
 * @license    http://opensource.org/licenses/bsd-license.php New BSD License
 * @version    Release: 1.9.0RC1
 * @link       http://pear.php.net/package/PEAR
 * @since      Class available since Release 1.4.0a1
 */
class PEAR_Installer_Role_Src extends PEAR_Installer_Role_Common
{
    function setup(&$installer, $pkg, $atts, $file)
    {
        $installer->source_files++;
    }
}
?>