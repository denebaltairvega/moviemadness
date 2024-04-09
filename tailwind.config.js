/** @type {import('tailwindcss').Config} */
const colors = require('tailwindcss/colors')
import preset from './vendor/filament/support/tailwind.config.preset'

export default {
  presets: [preset],
  content: [
    "./resources/**/*.blade.php",
    "./resources/**/*.js",
    "./vendor/filament/**/*.blade.php"
  ],
  theme: {
    extend: {
      colors: {
        danger: colors.rose,
        primary: colors.blue,
        success: colors.green,
        warning: colors.yellow,
      },
      fontFamily: {
        rubik: ["Rubik", "sans-serif"]
      },
      gridTemplateColumns: {
        ram: 'repeat(auto-fit, minmax(150px, 1fr))'
      }
    },
  },
  plugins: [
    require('@tailwindcss/forms'),
    require('@tailwindcss/typography'),
  ],
}

