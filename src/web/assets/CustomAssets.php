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
use craft\helpers\App;
use craft\web\AssetBundle;
use craft\web\assets\cp\CpAsset;
use doublesecretagency\cpjs\CpJs;
use doublesecretagency\cpjs\models\Settings;

/**
 * Class CustomAssets
 * @since 2.1.0
 */
class CustomAssets extends AssetBundle
{

    /**
     * @inheritdoc
     */
    public function init(): void
    {
        parent::init();

        // Requires standard CP assets to be loaded first
        $this->depends = [CpAsset::class];

        // Get plugin settings
        /** @var Settings $settings */
        $settings = CpJs::$plugin->getSettings();

        // Get the file (or files) specified
        $file = trim($settings['jsFile']);

        // If no file was specified, bail
        if (!$file) {
            return;
        }

        // Allow for comma-separated file paths
        $files = explode(',', $file);

        // Loop through specified files
        foreach ($files as $file) {

            // Parse each filename for aliases
            $file = App::parseEnv(trim($file));

            // If no file specified, skip to the next
            if (!$file) {
                continue;
            }

            // If cache busting is enabled
            if ($settings['cacheBusting']) {
                // Reference file with a hash
                $this->js[] = $this->_addHash($file);
            } else {
                // Reference file without a hash
                $this->js[] = $file;
            }

        }
    }

    /**
     * Add a unique file hash for cache busting.
     *
     * @param string $file
     * @return string
     */
    private function _addHash(string $file): string
    {
        // Get file contents
        $contents = @file_get_contents($file);

        // If unable to retrieve file contents
        if (!$contents) {
            // Log warning
            Craft::warning("Can't bust cache of CP JS, unable to load contents of $file");
            // Return file without hash
            return $file;
        }

        // Get hash of contents
        $hash = @sha1($contents);

        // If unable to hash file contents
        if (!$hash) {
            // Log warning
            Craft::warning("Can't bust cache for CP JS, unable to hash contents of $file");
            // Return file without hash
            return $file;
        }

        // Return file with hash
        return "{$file}?e={$hash}";
    }

}
