# divTOjstree
javascript/requirejs module converting HTML elements to jstree elements

## Basic Concept

This module let you to convert an HTML element to an Jstree element.
HTML element example:
``` html
<div class="jstree option-TESTNAME"></div>
```
TESTNAME must mach an object configuration:

``` javascript
define(function () {
    var configurations = {};
    configurations["TESTNAME"] = {
        "onClickCallback": function (nodeElement) {
             //calback fot the click events
        },
        "serverBasePath": "./stubServer.json" 
    };
    return configurations;
});
```

See the directory ./example.


## Usage with Require.js: example

Webpage using the module:
- include require.js by stating the main javascript:
``` html
 <script data-main="js/main" src="./bower_components/requirejs/require.js"></script>
```
- declare one or mode HTML element with class jstree and option-CONFIGURATION-NAME
``` html
 <div class="jstree option-test1"></div>
```

where the files are:

main.js (main javascript file)
``` javascript
//configure require
require.config({baseUrl: "./",
    paths: {
        jquery: 'bower_components/jquery/dist/jquery',
        jstree: 'bower_components/jstree/dist/jstree',
        confs: 'js/JstreesConfigurations',
        divTOjstree: 'bower_components/divTOjstree/src/divTOjstree'
    }
});

requirejs(['confs','divTOjstree','jstree', 'jquery'], function (configurations,divTOjstree) {
   divTOjstree(configurations); //use library
});
```


JstreesConfigurations.js (configurations)
``` javascript
define(function () {
    var configurations = {};
    configurations["test1"] = {
        "onClickCallback": function (nodeElement) {
            console.log("clicked elmenet", nodeElement);
        },
        "serverBasePath": "./stubServer.json"
    };
    return configurations;
});
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



