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
use craft\base\Model;
use craft\base\Plugin;
use craft\events\TemplateEvent;
use craft\web\View;
use doublesecretagency\cpjs\models\Settings;
use doublesecretagency\cpjs\web\assets\CustomAssets;
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
    public static CpJs $plugin;

    /**
     * @var bool The plugin has a settings page.
     */
    public bool $hasCpSettings = true;

    /**
     * @inheritdoc
     */
    public function init(): void
    {
        parent::init();
        self::$plugin = $this;

        // If not control panel request, bail
        if (!Craft::$app->getRequest()->getIsCpRequest()) {
            return;
        }

        // Load JS before page template is rendered
        Event::on(
            View::class,
            View::EVENT_BEFORE_RENDER_PAGE_TEMPLATE,
            function (TemplateEvent $event) {

                // Get view
                $view = Craft::$app->getView();

                // Load JS file
                $view->registerAssetBundle(CustomAssets::class);

                // Load additional JS
                /** @var Settings $settings */
                $settings = $this->getSettings();
                $js = trim($settings->additionalJs);
                if ($js) {
                    $view->registerJs($js, View::POS_END);
                }

            }
        );
    }

    /**
     * @inheritdoc
     */
    protected function createSettingsModel(): ?Model
    {
        return new Settings();
    }

    /**
     * @inheritdoc
     */
    protected function settingsHtml(): ?string
    {
        // Get the override keys
        $overrideKeys = array_keys(Craft::$app->getConfig()->getConfigFromFile('cp-js'));

        return Craft::$app->getView()->renderTemplate('cp-js/settings', [
            'settings' => $this->getSettings(),
            'overrideKeys' => $overrideKeys,
            'docsUrl' => $this->documentationUrl,
        ]);
    }

}
