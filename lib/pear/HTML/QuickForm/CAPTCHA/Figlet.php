<?php

/* vim: set expandtab tabstop=4 shiftwidth=4: */

/**
 * Element for HTML_QuickForm to display a CAPTCHA figlet
 *
 * The HTML_QuickForm_CAPTCHA package adds an element to the
 * HTML_QuickForm package to display a CAPTCHA figlet.
 *
 * This package requires the use of a PHP session.
 *
 * PHP versions 4 and 5
 *
 * @category   HTML
 * @package    HTML_QuickForm_CAPTCHA
 * @author     Philippe Jausions <Philippe.Jausions@11abacus.com>
 * @copyright  2006 by 11abacus
 * @license    LGPL
 * @version    CVS: $Id: Figlet.php 70 2011-04-11 07:15:31Z xxserg@gmail.com $
 * @link       http://pear.php.net/package/HTML_QuickForm_CAPTCHA
 */

/**
 * Required packages
 */
require_once 'HTML/QuickForm/CAPTCHA.php';
require_once 'Text/CAPTCHA/Driver/Figlet.php';

/**
 * Element for HTML_QuickForm to display a CAPTCHA figlet
 *
 * The HTML_QuickForm_CAPTCHA package adds an element to the
 * HTML_QuickForm package to display a CAPTCHA figlet
 *
 * Options for the element
 * <ul>
 *  <li>'width'      (integer)  Width of figlet (default is 200px)</li>
 *  <li>'output'     (string)   Output format: "html", "text" or
 *                              "javascript" (default is "html").</li>
 *  <li>'length'     (integer)  number of letters in the figlet
 *                              (default is 6)</li>
 *  <li>'options'    (array)    only index supported is "font_file", which
 *                              should either be one figlet font file path,
 *                              or an array of figlet font file paths
 *                              (one we be picked randomly)</li>
 *  <li>'sessionVar' (string)   name of session variable containing
 *                              the Text_CAPTCHA instance (defaults to
 *                              _HTML_QuickForm_CAPTCHA.)</li>
 * </ul>
 *
 * This package requires the use of a PHP session.
 *
 * PHP versions 4 and 5
 *
 * @category   HTML
 * @package    HTML_QuickForm_CAPTCHA
 * @author     Philippe Jausions <Philippe.Jausions@11abacus.com>
 * @copyright  2006 by 11abacus
 * @license    LGPL
 * @version    Release: 0.2.1
 * @link       http://pear.php.net/package/HTML_QuickForm_CAPTCHA
 * @see        Text_CAPTCHA_Driver_Equation
 */
class HTML_QuickForm_CAPTCHA_Figlet extends HTML_QuickForm_CAPTCHA
{
    /**
     * Default options
     *
     * @var array
     * @access protected
     */
    var $_options = array(
            'sessionVar'    => '_HTML_QuickForm_CAPTCHA',
            'output'        => 'html',
            'width'         => 200,
            'length'        => 6,
            'phrase'        => null,
            );

    /**
     * CAPTCHA driver
     *
     * @var string
     * @access protected
     */
    var $_CAPTCHA_driver = 'Figlet';


    /**
     * Returns the HTML for the CAPTCHA
     *
     * This can be overwritten by sub-classes for specific output behavior
     * (for instance the Image CAPTCHA displays an image)
     *
     * @access     public
     * @return     string
     */
    function toHtml()
    {
        $result = $this->_initCAPTCHA();
        if (PEAR::isError($result)) {
            return $result;
        }

        $attr = $this->_attributes;
        unset($attr['type']);
        unset($attr['value']);
        unset($attr['name']);

        $html = $this->_getTabs()
                . '<div' . $this->_getAttrString($attr) . '>'
                . $_SESSION[$this->_options['sessionVar']]->getCAPTCHA()
                . '</div>';
        return $html;
    }
}

/**
 * Register the class with QuickForm
 */
if (class_exists('HTML_QuickForm')) {
    HTML_QuickForm::registerElementType('CAPTCHA_Figlet',
            'HTML/QuickForm/CAPTCHA/Figlet.php',
            'HTML_QuickForm_CAPTCHA_Figlet');
}

?>