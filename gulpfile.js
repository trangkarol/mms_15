const elixir = require('laravel-elixir');

require('laravel-elixir-vue-2');

/*
 |--------------------------------------------------------------------------
 | Elixir Asset Management
 |--------------------------------------------------------------------------
 |
 | Elixir provides a clean, fluent API for defining some basic Gulp tasks
 | for your Laravel application. By default, we are compiling the Sass
 | file for your application as well as publishing vendor resources.
 |
 */

elixir((mix) => {
    mix.sass('app.scss')
        .copy([
                'resources/assets/js/common/common.js',
            ], 'public/common/js/')

        .copy([
                'resources/assets/js/admin/team.js',
                'resources/assets/js/admin/user.js',
                'resources/assets/js/admin/project.js',
            ], 'public/admin/js/')

       .webpack('app.js');
});
