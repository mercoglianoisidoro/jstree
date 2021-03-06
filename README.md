# jstree



## Install

Via Composer

``` bash
composer require isidoro/jstree
```

## Usage

``` php

Simplest usage:

To get jstree showing a directory (here the defaultPathForData):  

    $config = new JstreeConfig(array('basePath'=>'defaultPathForData/'));
    //this base path will be the root path for JstreeFileSystem

    header('Content-Type: application/json');
    echo (new JstreeFileSystem('directory_to_explore',$config))->getList();
    /**
     * Meaning:
     * explore the path  'defaultPathForData/directory_to_explore'
     * get it in the json format for the jstree plugin
     */

See the 'demo' directory to have a complete example (js + php)



Other configuration:

    //to show files
    $config->setShowDirectories(false);

    //to show directories
    $config->setShowFiles(false);

    //filtering on extension
    //$config->setExtensionsToShowFromList('cpp;txt');

All the configurations can be set by the array passed to the JstreeConfig constructor.

```

## Change log

Please see [CHANGELOG](CHANGELOG.md) for more information what has changed recently.

## Contributing

Please see [CONTRIBUTING](CONTRIBUTING.md) for details.

## Security

If you discover any security related issues, please email mercoglianoisidoro.com instead of using the issue tracker.

## Credits

- [isidoro][mercogliano.isidoro@gmail.com]
- [All Contributors][link-contributors]

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.


