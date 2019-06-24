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
use craft\events\TemplateEvent;
use craft\web\View;
use doublesecretagency\cpjs\models\Settings;
use doublesecretagency\cpjs\web\assets\CustomAssets;
use doublesecretagency\cpjs\web\assets\SettingsAssets;
use yii\base\Event;

/**
 * Class CpJs
 * @since 2.0.0
 */
class CpJs extends Plugin
{

    /**
     * @var CpJs Self-referential plugin property.
     */
    public static $plugin;

    /**
     * @var bool The plugin has a settings page.
     */
    public $hasCpSettings = true;

    /**
     * @inheritDoc
     */
    public function init()
    {
        parent::init();
        self::$plugin = $this;

        // If not control panel request, bail
        if (!Craft::$app->getRequest()->getIsCpRequest()) {
            return false;
        }

        // Load JS before template is rendered
        Event::on(
            View::class,
            View::EVENT_BEFORE_RENDER_TEMPLATE,
            function (TemplateEvent $event) {

                // Get view
                $view = Craft::$app->getView();

                // Load JS file
                $view->registerAssetBundle(CustomAssets::class);

                // Load additional JS
                $settings = $this->getSettings();
                $js = trim($settings->additionalJs);
                if ($js) {
                    $view->registerJs($js, View::POS_END);
                }

            }
        );
    }

    /**
     * @return Settings Plugin settings model.
     */
    protected function createSettingsModel()
    {
        return new Settings();
    }

    /**
     * @return string The fully rendered settings template.
     */
    protected function settingsHtml(): string
    {
        $view = Craft::$app->getView();
        $view->registerAssetBundle(SettingsAssets::class);
        $view->registerCss('.autosuggest__results-container {z-index: 10;}');

        $overrideKeys = array_keys(Craft::$app->getConfig()->getConfigFromFile('cp-js'));

        return $view->renderTemplate('cp-js/settings', [
            'settings' => $this->getSettings(),
            'overrideKeys' => $overrideKeys,
            'docsUrl' => $this->documentationUrl,
        ]);
    }

}
