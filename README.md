Control Panel JS plugin for Craft CMS
======================================

Easily insert additional JavaScript into the Craft Control Panel.

After you've installed the plugin, go to:

- **Settings > Plugins > Control Panel JS**

Your custom JavaScript can be saved in either (or both) of two places:

**1) An external file in your public directory...**
![](src/resources/img/example-jsFile.png)

**2) The "Additional JavaScript" field on the settings page...**
![](src/resources/img/example-additionalJs.png)

You can customize your JavaScript in any way you see fit!

***

## Environment-aware file path

If you'd like to set your JavaScript file path at the _environment_ level, then you'll simply want to create a `/config/cp-js.php` file, and enter something like this...

```php
return [
    '*' => [],
    'dev' => [
        'jsFile' => 'http://local.dev/path/to/cp.js',
    ],
    'production' => [
        'jsFile' => 'http://example.com/path/to/cp.js',
    ]
];
```

You can also keep the file path out of your repo entirely, by using `.env` variables to set the JS file path...

```php
return [
    'jsFile' => getenv('CP_JS_FILE'),
];
```

With that in place, you can add this to your `.env` file...

```dotenv
# Path to JS file for the Control Panel
CP_JS_FILE="http://example.com/path/to/cp.js"
```

***

## Anything else?

We've got other plugins too!

Check out the full catalog at [doublesecretagency.com/plugins](https://www.doublesecretagency.com/plugins)
