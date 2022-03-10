const mix = require("laravel-mix")

const appPublicPath = global.process.env.MIX_PUBLIC_PATH || 'public';

// mix.setPublicPath(`${appPublicPath}/assets/auth/js/`);
if (mix.inProduction()) {
    mix.version();
}
mix.js(['./resources/assets/js/auth/index.js'], 'public/assets/js/auth/index.js')

mix.styles([
    './resources/assets/css/auth/app.css',
], 'public/assets/css/auth/app.css')