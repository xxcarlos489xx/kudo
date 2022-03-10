const mix = require("laravel-mix")

const appPublicPath = global.process.env.MIX_PUBLIC_PATH || 'public';

// mix.setPublicPath(`${appPublicPath}/assets/dashboard/js/`);
if (mix.inProduction()) {
    mix.version();
}
mix.js(['./resources/assets/js/dashboard/index.js'], 'public/assets/js/dashboard/index.js')

mix.styles([
    './resources/assets/css/dashboard/app.css',
], 'public/assets/css/dashboard/app.css')