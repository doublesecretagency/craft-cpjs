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

namespace doublesecretagency\cpjs\models;

use craft\base\Model;

/**
 * Class Settings
 * @since 2.0.0
 */
class Settings extends Model
{

    /**
     * @var string Path for the JS file to load in the control panel.
     */
    public string $jsFile = '';

    /**
     * @var string Any additional JS which may be added directly.
     */
    public string $additionalJs = '';

    /**
     * @var bool Whether to enable the hash-based cache busting.
     */
    public bool $cacheBusting = true;

}
