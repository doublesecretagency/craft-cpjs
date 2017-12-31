<?php
/**
 * Control Panel JS plugin for Craft CMS
 *
 * Add custom JS to your Control Panel.
 *
 * @author    Double Secret Agency
 * @link      https://www.doublesecretagency.com/
 * @copyright Copyright (c) 2014 Double Secret Agency
 */

namespace doublesecretagency\cpjs;

use Craft;
use craft\base\Plugin;

use doublesecretagency\cpjs\models\Settings;
use doublesecretagency\cpjs\web\assets\SettingsAssets;

/**
 * Class CpJs
 * @since 2.0.0
 */
class CpJs extends Plugin
{

    /** @var Plugin  $plugin  Self-referential plugin property. */
    public static $plugin;

    /** @var bool  $hasCpSettings  The plugin has a settings page. */
    public $hasCpSettings = true;

    /** @inheritDoc */
    public function init()
    {
        parent::init();
        self::$plugin = $this;
        if (Craft::$app->getRequest()->getIsCpRequest()) {
            $this->_renderJs();
        }
    }

    /**
     * @return Settings  Plugin settings model.
     */
    protected function createSettingsModel()
    {
        return new Settings();
    }

    /**
     * @return string  The fully rendered settings template.
     */
    protected function settingsHtml(): string
    {
        $this->_loadCodeMirror();
        $overrideKeys = array_keys(Craft::$app->getConfig()->getConfigFromFile('cp-js'));
        return Craft::$app->getView()->renderTemplate('cp-js/settings', [
            'settings' => $this->getSettings(),
            'overrideKeys' => $overrideKeys,
            'docsUrl' => $this->documentationUrl,
        ]);
    }

    /**
     * @return void
     */
    private function _loadCodeMirror()
    {
        $view = Craft::$app->getView();
        $view->registerAssetBundle(SettingsAssets::class);
        $view->registerJs('
$(function () {
    console.log("Loading CodeMirror...");
    CodeMirror.fromTextArea(document.getElementById("settings-additionalJs"), {
        indentUnit: 4,
        styleActiveLine: true,
        lineNumbers: true,
        lineWrapping: true,
        theme: "blackboard"
    });
});');
    }

    /**
     * @return void
     */
    private function _renderJs()
    {
        $view = Craft::$app->getView();
        $settings = $this->getSettings();
        if (trim($settings->jsFile)) {
            $filepath = $settings->jsFile;
            if ($hash = @sha1_file($filepath)) {
                $view->registerJsFile($filepath.'?e='.$hash);
            } else {
                $view->registerJsFile($filepath);
            }
        }
        if (trim($settings->additionalJs)) {
            $view->registerJs($settings->additionalJs);
        }
    }

}