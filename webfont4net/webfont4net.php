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

        // joomla base
        $doc = &JFactory::getDocument();
        $app = &JFactory::getApplication();

        // run in admin
        if ($app->isAdmin() && !$this->params->get('adminenabled'))
            return true;

        // base variables
        $load_local = $this->params->get('local');
        $timeout    = $this->params->get('timeout');

        // load modules
        $google_load   = $this->params->get('googleLoad');
        $typekit_load  = $this->params->get('typekitLoad');
        $fontdeck_load = $this->params->get('fontdeckLoad');
        $fontscom_load = $this->params->get('fontscomLoad');
        $custom_load   = $this->params->get('customLoad');

        // modules
        $google = "";
        $typekit = "";
        $fontdeck = "";
        $fontscom = "";
        $custom = "";

        // load main script
        if ($load_local) {
            $doc->addScript('media/design4net/js/webfont.js');
        } else {
            $doc->addScript('http://ajax.googleapis.com/ajax/libs/webfont/1.4.7/webfont.js');
        }

        // google module
        if ($google_load) {

            // google subset
            $google_subset = array();
            if ($this->params->get('cyrillic')) {
                $google_subset[] = 'cyrillic';
            }
            if ($this->params->get('cyrillicE')) {
                $google_subset[] = 'cyrillic-ext';
            }
            if ($this->params->get('latin')) {
                $google_subset[] = 'latin';
            }
            if ($this->params->get('latinE')) {
                $google_subset[] = 'latin-ext';
            }
            if ($this->params->get('greek')) {
                $google_subset[] = 'greek';
            }
            if ($this->params->get('greekE')) {
                $google_subset[] = 'greek-ext';
            }
            if ($this->params->get('khmer')) {
                $google_subset[] = 'khmer';
            }
            if ($this->params->get('vietnamese')) {
                $google_subset[] = 'vietnamese';
            }

            // google families
            if ($this->params->get('googleFamilies')) {
                $google = "google: {" . "\n";

                $google_families = array();
                $google_families = explode("\r\n", $this->params->get('googleFamilies'));

                $google .= "families: [";

                for ($i = 0; $i < count($google_families); $i++) {
                    $google .= "'" . $google_families[$i];
                    if ($i == (count($google_families) - 1)) {
                        if ($google_subset) {
                            $google .= ":" . implode(",", $google_subset);
                        }
                        $google .= "'";
                    } else {
                        $google .= "', ";
                    }
                }
                $google .= "]" . "\n";
                $google .= "}";
            }
        }

        // typekit module
        if ($typekit_load) {

            // typekit id
            $typekit_id = $this->params->get('typekitId');

            if ($typekit_id) {
                $typekit  = "typekit: {" . "\n";
                $typekit .= "id:" . $typekit_id . "\n";
                $typekit .= "]" . "\n";
                $typekit .= "}";
            }
        }

        // fontdeck module
        if ($fontdeck_load) {

            // fontdeck id
            $fontdeck_id = $this->params->get('fontdeckId');

            if ($fontdeck_id) {
                $fontdeck  = "fontdeck: {" . "\n";
                $fontdeck .= "id:" . $fontdeck_id . "\n";
                $fontdeck .= "]" . "\n";
                $fontdeck .= "}";
            }
        }

        // fontscom module
        if ($fontscom_load) {

            // fontscom project id
            $fontscom_id = $this->params->get('fontscomId');

            if ($fontscom_id) {
                $fontscom  = "monotype: {" . "\n";
                $fontscom .= "projectId:" . $fontscom_id . "\n";
                $fontscom .= "]" . "\n";
                $fontscom .= "}";
            }
        }

        // custom module
        if ($custom_load) {

            // custom css file
            $custom_file = $this->params->get('customFile');

            // custom families
            if ($this->params->get('customFamilies') && ($custom_file != -1)) {

                $custom = "custom: {" . "\n";

                $custom_families = array();
                $custom_families = explode("\r\n", $this->params->get('customFamilies'));

                $custom .= "families: ['" . implode("', '", $custom_families) . "']," . "\n";
                $custom .= "urls: ['" . JURI::base() . "media/design4net/fonts/" . $custom_file . "']" . "\n";

                $custom .= "}";
            }
        }


        // load ini script
        $modules = array();

        if ($google) {
            $modules[] = $google;
        }
        if ($typekit) {
            $modules[] = $typekit;
        }
        if ($fontdeck) {
            $modules[] = $fontdeck;
        }
        if ($fontscom) {
            $modules[] = $fontscom;
        }
        if ($custom) {
            $modules[] = $custom;
        }
        if ($timeout) {
            $modules[] = "timeout:" . $timeout;
        }

        if ($modules) {
            $webfont_ini  = "\n" . "WebFont.load({" . "\n";
            $webfont_ini .= implode(",\n", $modules);
            $webfont_ini .= "\n" . "});";
        }

        $doc->addScriptDeclaration($webfont_ini);

        return true;
    }
}
?>
