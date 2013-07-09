<?php
/**
 * @package    plg_sys_webfont4net
 * @author     Design4Net (Sergey Kupletsky)
 * @copyright  Copyright by Design4Net © 2013. All rights reserved.
 * @license    GNU/GPLv3 http://www.gnu.org/licenses/gpl-3.0.html
 */

// no direct access
defined('_JEXEC') or die('Restricted access');

class plgSystemWebFont4Net extends JPlugin {
    function onBeforeCompileHead()
    {

        // load scripts for this plugins
        $doc = &JFactory::getDocument();

        // variables
        $load_local = $this->params->get('local');

        // load main script
        if ($load_local) {
            $doc->addScript('media/design4net/js/webfont.js');
        } else {
            $doc->addScript('http://ajax.googleapis.com/ajax/libs/webfont/1.4.7/webfont.js');
        }

        // google
        $subset = $this->params->get('local');

        // load ini script
        $webfont_ini = 'alert( \'Hello Joomla!\' )';

        $doc->addScriptDeclaration($webfont_ini);

    }
}
?>
