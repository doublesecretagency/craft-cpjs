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

namespace doublesecretagency\cpjs\web\assets;

use Craft;
use craft\web\AssetBundle;
use craft\web\assets\cp\CpAsset;
use doublesecretagency\cpjs\CpJs;

/**
 * Class CustomAssets
 * @since 2.1.0
 */
class CustomAssets extends AssetBundle
{

    /**
     * @inheritDoc
     */
    public function init()
    {
        parent::init();

        $this->depends = [CpAsset::class];

        $settings = CpJs::$plugin->getSettings();

        $file = trim(Craft::parseEnv($settings['jsFile']));

        if ($file) {

            // Cache buster
            if ($hash = @sha1_file($file)) {
                $file .= '?e='.$hash;
            }

            // Load JS file
            $this->js = [$file];

        }
    }

}
