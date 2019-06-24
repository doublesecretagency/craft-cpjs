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

use craft\web\AssetBundle;
use craft\web\assets\cp\CpAsset;

/**
 * Class SettingsAssets
 * @since 2.0.0
 */
class SettingsAssets extends AssetBundle
{

    /**
     * @inheritDoc
     */
    public function init()
    {
        parent::init();

        $this->sourcePath = '@doublesecretagency/cpjs/resources';
        $this->depends = [CpAsset::class];

        $this->css = [
            'css/codemirror.css',
            'css/blackboard.css',
        ];

        $this->js = [
            'js/codemirror-javascript.js',
            'js/blackboard.js',
        ];
    }

}
