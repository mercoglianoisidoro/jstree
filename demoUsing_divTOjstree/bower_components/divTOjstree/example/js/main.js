require.config({baseUrl: "./",
    paths: {
        jquery: 'bower_components/jquery/dist/jquery',
        jstree: 'bower_components/jstree/dist/jstree',
        confs: 'js/JstreesConfigurations',
//        divTOjstree: 'bower_components/divTOjstree/src/divTOjstree'
        divTOjstree: '../src/divTOjstree'
    }
});

requirejs(['confs','divTOjstree','jstree', 'jquery'], function (configurations,divTOjstree) {
   divTOjstree(configurations);
});

