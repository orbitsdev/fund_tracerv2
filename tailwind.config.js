import preset from './vendor/filament/support/tailwind.config.preset'

const colors = require('tailwindcss/colors')
export default {
    presets: [preset],
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './vendor/laravel/jetstream/**/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',

        './app/Filament/**/*.php',
        './resources/views/**/*.blade.php',
        './vendor/filament/**/*.blade.php',
    ],


    theme: {
        extend: {
          colors: {

            gray: colors.neutral,
          }
        }

    }


}
