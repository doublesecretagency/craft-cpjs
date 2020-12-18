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

        $finalPaths = [];

        if ($file) {

            $files = explode(',', $file);
            foreach ($files as $file) {
                $file = trim($file);

                // Cache buster
                if ($hash = @sha1_file($file)) {
                    $file .= '?e='.$hash;
                }

                array_push($finalPaths, $file);

            }

            // Load all cachebusted JS files
            $this->js = $finalPaths;

        }
    }

}
