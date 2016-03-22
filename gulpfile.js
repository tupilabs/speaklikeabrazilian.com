var elixir = require('laravel-elixir');

/*
 |--------------------------------------------------------------------------
 | Elixir Asset Management
 |--------------------------------------------------------------------------
 |
 | Elixir provides a clean, fluent API for defining some basic Gulp tasks
 | for your Laravel application. By default, we are compiling the Sass
 | file for our application, as well as publishing vendor resources.
 |
 */

elixir(function(mix) {
  //mix.sass('app.scss');

  mix.copy(
     './resources/assets/bower/semantic/dist/themes',
     './public/css/themes'
   );

   mix.styles([
     './resources/assets/bower/semantic/dist/semantic.min.css',
     './resources/assets/sass/app.css'
   ],
   'public/css/slbr.css');

   mix.scripts([
      './resources/assets/bower/jquery/dist/jquery.js',
      './resources/assets/bower/semantic/dist/semantic.js',
      './resources/assets/bower/jquery-colorbox/jquery.colorbox.js',
      './resources/assets/app.js'
    ]);

});
