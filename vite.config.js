import { defineConfig } from 'vite';
import path from 'path';

export default defineConfig(({ command, mode }) => {
    const isProd = mode === 'production';
    
    return {
        root: path.resolve(__dirname),

        server: {
            port: 5173,
            strictPort: true,
            host: true,  // Permite conexiones desde la red local
            cors: true,  // Habilita CORS para peticiones desde WP
            hmr: {
                protocol: 'ws',
                host: 'localhost',
                port: 5173,
            },

            // Proxy: reenviar todas las peticiones "HTML / rutas de WP" al backend en Local (puerto 10028)
            // y permitir que Vite sirva sus propios assets (ej: /assets/, /@vite/, /@modules, /__vite__).
            proxy: {
                // Proxy específico para rutas de WordPress
                [ /^(?!\/assets\/|\/@vite\/|\/@modules\/|\/__vite__|\/favicon.ico|\/robots.txt).*$/ ]: {
                    target: 'http://localhost:10028', // tu WP en Local
                    changeOrigin: true,
                    secure: false,
                    ws: true, // websocket passthrough para HMR cuando aplique
                    logLevel: 'debug',
                }
            }
        },

        build: {
            outDir: path.resolve(__dirname, 'dist'),
            emptyOutDir: true,
            manifest: true, // always generate manifest
            cssCodeSplit: true,
            rollupOptions: {
                input: {
                    main: path.resolve(__dirname, 'assets/js/main.js'),
                    editor: path.resolve(__dirname, 'assets/js/editor.js'),
                },
                output: {
                    entryFileNames: isProd ? 'assets/js/[name].[hash].js' : 'assets/js/[name].js',
                    chunkFileNames: isProd ? 'assets/js/chunks/[name].[hash].js' : 'assets/js/chunks/[name].js',
                    assetFileNames: (assetInfo) => {
                        const info = assetInfo.name || '';
                        const extType = path.extname(info).toLowerCase();
                        
                        // CSS files go to assets/css/
                        if (extType === '.css') {
                            return isProd 
                                ? 'assets/css/[name].[hash][extname]' 
                                : 'assets/css/[name][extname]';
                        }
                        
                        // Images go to assets/images/
                        if (['.png', '.jpg', '.jpeg', '.gif', '.svg', '.webp', '.ico'].includes(extType)) {
                            return isProd 
                                ? 'assets/images/[name].[hash][extname]' 
                                : 'assets/images/[name][extname]';
                        }
                        
                        // Fonts go to assets/fonts/
                        if (['.woff', '.woff2', '.ttf', '.eot', '.otf'].includes(extType)) {
                            return isProd 
                                ? 'assets/fonts/[name].[hash][extname]' 
                                : 'assets/fonts/[name][extname]';
                        }
                        
                        // Other assets go to assets/
                        return isProd 
                            ? 'assets/[name].[hash][extname]' 
                            : 'assets/[name][extname]';
                    },
                },
            },
        },
         
        css: {},
        resolve: {
            alias: {
                '@': path.resolve(__dirname, 'assets'),
                '@css': path.resolve(__dirname, 'assets/css'),
                '@js': path.resolve(__dirname, 'assets/js'),
                '@images': path.resolve(__dirname, 'assets/images'),
                '@fonts': path.resolve(__dirname, 'assets/fonts'),
                '~theme': path.resolve(__dirname),
            },
        },
    };
});
