import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    plugins: [
        laravel({
            input: [
                'resources/sass/app.scss',
                'resources/js/app.js',
            ],
            refresh: true,
        }),
    ],
    css: {
        preprocessorOptions: {
            scss: {
                // O Bootstrap 5.x ainda usa a API legada do Sass (@import,
                // funções globais como mix()/red()/green()/blue()) por baixo
                // dos panos; isso só muda quando o Bootstrap migrar para
                // @use/@forward na v6. Silenciamos apenas essas categorias de
                // aviso vindas de dependências que não controlamos — o CSS
                // gerado continua idêntico, só some o ruído no log do build.
                silenceDeprecations: ['import', 'global-builtin', 'color-functions'],
                quietDeps: true,
            },
        },
    },
});
