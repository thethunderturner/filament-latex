// const preset = require('./vendor/filament/filament/tailwind.config.preset')

/** @type {import('tailwindcss').Config} */
module.exports = {
    content: [
        './app/Filament/**/*.php',
        './resources/views/filament/**/*.blade.php',
        './vendor/filament/**/*.blade.php',
    ],
}
