var elixir = require('laravel-elixir');

require('laravel-elixir-modernizr');

elixir(function (mix) {
    mix
    //fonts and images copy to public
        .copy('node_modules/bootstrap-sass/assets/fonts/bootstrap/**', 'public/fonts/bootstrap')
        .copy('node_modules/font-awesome/fonts', 'public/fonts/fontawesome')
        .copy('node_modules/open-sans-fontface/fonts/**', 'public/fonts/open-sans')
        //.copy('./resources/assets/images/**', 'public/images')
        //frontend sass
        .sass('./resources/assets/sass/app.scss', 'public/css/')
        .modernizr('', 'public/js/vendor/modernizr-custom.js')
        .scripts([
            'node_modules/jquery/dist/jquery.js',
            'node_modules/bootstrap-sass/assets/javascripts/bootstrap.js',
            'node_modules/jasny-bootstrap/dist/js/jasny-bootstrap.js',
            'node_modules/select2/dist/js/select2.js',
            './resources/assets/js/**/*.js'
        ], 'public/js/app.js', './')
        //versioning
        .version([
            'css/app.css',
            'js/app.js',
        ]);
});
