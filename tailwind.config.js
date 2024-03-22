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
            'system': {
              50: '#ecfeff',
              100: '#cefbff',
              200: '#a3f4fe',
              300: '#64eafc',
              400: '#1dd5f3',
              500: '#01b8d9',
              600: '#0490b3c7',
              700: '#135e77',
              800: '#144f65',
              900: '#073445',
            },
            'trust': {
              50: '#edf9ff',
              100: '#d8f1ff',
              200: '#b9e6ff',
              300: '#89d8ff',
              400: '#51c1ff',
              500: '#29a3ff',
              600: '#0980fe',
              700: '#0b6bea',
              800: '#1057bd',
              900: '#112f5a',
            },
          }
        }

    }


}
