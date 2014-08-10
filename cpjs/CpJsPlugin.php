<?php
namespace Craft;

class CpJsPlugin extends BasePlugin
{

    public function init()
    {
        parent::init();
        if (craft()->request->isCpRequest()) {
            $this->_renderJs();
        }
    }

    public function getName()
    {
        return Craft::t('Control Panel JS');
    }

    public function getVersion()
    {
        return '1.0.3';
    }

    public function getDeveloper()
    {
        return 'Double Secret Agency';
    }

    public function getDeveloperUrl()
    {
        return 'https://github.com/lindseydiloreto/craft-cpjs';
        //return 'http://doublesecretagency.com';
    }

    protected function defineSettings()
    {
        return array(
            'jsFile'       => array(AttributeType::String),
            'additionalJs' => array(AttributeType::String, 'column' => ColumnType::Text),
        );
    }

    public function getSettingsHtml()
    {
        craft()->templates->includeCssResource('cpjs/css/settings.css');
        return craft()->templates->render('cpjs/_settings', array(
            'settings' => $this->getSettings(),
        ));
    }

    private function _renderJs()
    {
        $settings = $this->getSettings();
        if (trim($settings->jsFile)) {
            $filepath = craft()->config->parseEnvironmentString($settings->jsFile);
            if ($hash = @sha1_file($filepath)) {
                craft()->templates->includeJsFile($filepath.'?e='.$hash);
            } else {
                craft()->userSession->setError('Control Panel JS - File does not exist ('.basename($filepath).')');
            }
        }
        if (trim($settings->additionalJs)) {
            craft()->templates->includeJs($settings->additionalJs);
        }
    }
    
}
