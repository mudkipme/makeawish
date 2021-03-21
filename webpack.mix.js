const mix = require('laravel-mix');

mix.ts('resources/src/app.ts', 'public/js')
    .vue()
    .postCss('resources/css/app.css', 'public/css', [
        require('postcss-nested')
    ])
    .extract();
