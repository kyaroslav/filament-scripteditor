const mix = require('laravel-mix');

mix.setPublicPath('dist')
mix.setResourceRoot('scripteditor')
mix.sourceMaps()
mix.version()

mix.copy([
], "dist/scripteditor");

