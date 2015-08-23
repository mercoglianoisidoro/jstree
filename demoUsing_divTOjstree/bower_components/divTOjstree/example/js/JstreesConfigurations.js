

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



