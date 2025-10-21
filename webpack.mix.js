const mix = require("laravel-mix");

mix.js("resources/js/app.js", "public/js")
    .css("resources/css/app.css", "public/css")
    .copy("resources/js/listings/create.js", "public/js/listings")
    .copy("resources/css/listings/create.css", "public/css/listings");
