import { defineConfig } from 'vite';
import path from 'path';

export default defineConfig(({ command, mode }) => {

    const isProd = mode === 'production';
    
    return {
    root: path.resolve(__dirname),
    build: {
        outDir: path.resolve(__dirname, 'dist'),
        emptyOutDir: true,
        manifest: isProd, // only generate manifest in production
        sourcemap: !isProd, // generate sourcemaps in development
        cssCodeSplit: true,

        rollupOptions: {
            input: {
                main: path.resolve(__dirname, 'assets/js/main.js'),
                editor: path.resolve(__dirname, 'assets/js/editor.js'),
            },
            output: {
                entryFileNames: isProd ? 'assets/js/[name].[hash].js' : 'assets/js/[name].js',
                chunkFileNames: isProd ? 'assets/js/chunks/[name].[hash].js' : 'assets/js/chunks/[name].js',
                assetFileNames: assetInfo => {
                    const extType = path.extname(assetInfo.name || '');
                    const name = path.basename(assetInfo.name || '');

                    if (extType === '.css') {
                        return isProd ? `assets/css/${name}.${extType}` : `assets/css/${name}.${extType}`;
                    }
                    return isProd ? `assets/${name}.${extType}` : `assets/${name}.${extType}`;
                },
            },
        },
        server: {
            port: 5173,
            strictPort: true,
            host: true, // needed for LocalWP
            hmr: {
                protocol: 'ws',
                host: 'localhost',
                port: 5173,
            },
        },
        css: {},
        resolve: {
            alias: {
                '@': path.resolve(__dirname, 'assets'),
                '@css': path.resolve(__dirname, 'assets/css'),
                '@js': path.resolve(__dirname, 'assets/js'),
                '@images': path.resolve(__dirname, 'assets/images'),
                '~theme': path.resolve(__dirname),
            },
        },
    },
    }
});
