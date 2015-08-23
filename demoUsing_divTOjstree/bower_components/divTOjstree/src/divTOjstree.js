    define(function () {
    /**
     * the goal of the module is to convert all element with class .jstree and having 
     * anothe .option-NAME class, (ex <div class="jstree option-test1"></div>)
     * to an object jstree
     * 
     * 
     * the module, a function, act like that:
     * - receive as input a configuration object (array of configurations)
     * - for each configuration search in the web page the HTML element that 
     *      shoud mach the name configuration ( configuration.name <-> element with classe ".jstree .option-name")
     * - define the initialize function (configuration object as input)
     * - the initialize function will create the jstree for each configuration object found
     * 
     *  example configuration 
     *  var configurations = {};
     *  configurations["nome2"] = {
     *                         "onClickCallback": function (nodeElement) {
     *                              console.log("clicked elmenet", nodeElement);
     *                         },
     *                         "serverBasePath": "./explorer.php"
     *                        };
     */


            console.debug("ditTOjstree module");
            /**
             * create an jstree on the base of the passed configurations 
             */
            var createJSTrees = function (configurations) {
            "use strict";
            var jsTrees = []; //array of objects

            //search for all the HTML elements with class .jstree, to filter then the 
            // on class option-NAME, whare NAME must correspond to a configuration element
            //every element 
            $('.jstree').each(function (index, element) {

                    //search all the jstree container 
                    //html elements with class jstree and another to define the configuration

                    var classElement = element.className; //css class of the element
                    //it should be in the form option-[name]
                    //so now we can extract [name]
                    var myRe = new RegExp("option-[a-z0-9]*");
                    var foundClassesNames = classElement.match(myRe);
                    var foundClassName = foundClassesNames[0]; //all class starting by "option-"
                    var foundAppName = foundClassName.split('-')[1];
                    if (configurations[foundAppName] != undefined) {
                        configurations[foundAppName].name = foundAppName; //we need to have the name inside the object
                        jsTrees[foundAppName] = configurations[foundAppName];
                    } else {
                        console.error(foundAppName + 'not found');
                    }

            });

            /**
            * Inizialize jstree elements: for each object passed 
            * it inizialise a jstree lib
            * @param configuration object
            */
            var initialize = function (appObject) {

                    $('.jstree').filter('.option-' + appObject.name)
                    /*supporto for the multi selection (not yet supported by this module)
                    .on('changed.jstree', function (e, data) {
                    var i, j= [];
                    selectedNodes = [];
                    for (i = 0, j = data.selected.length; i < j; i++) {
                    selectedNodes.push(data.instance.get_node(data.selected[i]));
                    }
                    })
                    */
                    .on('select_node.jstree', function (e, data) {
                      if (typeof appObject.onClickCallback === "function") {
                          appObject.onClickCallback(data.node);
                      }
                    })
                    .jstree({
                        'core': {
                            'data': {
                                    'url': function (node) {
                                        return node.id === '#' ?
                                        appObject.serverBasePath : appObject.serverBasePath + '?path=' + node.id;
                                        },
                                    "dataType": "json" // needed only if you do not supply JSON headers
                                    }
                        }
                    });     
            }

            //jsTrees array of all the jstree found

            console.log("jstree list:", jsTrees);
            var foundElement = false;
            for (var key in jsTrees) {
                initialize(jsTrees[key]);
                foundElement = true;
            }
            return foundElement;
        };

            return createJSTrees;//end of the module
        });



