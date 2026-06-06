import { defineConfig } from 'astro/config';

import tailwind from "@astrojs/tailwind";
import react from "@astrojs/react";

// https://astro.build/config
export default defineConfig({
  site: process.env.SITE_URL || 'https://ginecologiajyza.pe',
  integrations: [tailwind(), react()],
  build: {
    // Nunca inlinear - serviremos CSS sin bloquear con media="print"
    inlineStylesheets: 'never',
  },
  vite: {
    build: {
      minify: 'terser',
      cssCodeSplit: false, // Combinar en un solo archivo para mejor compresión
      // Comprimir CSS agresivamente
      cssMinify: true,
      terserOptions: {
        compress: {
          drop_console: true, // Remover console.log
          drop_debugger: true,
        },
        output: {
          comments: false,
        },
      },
      rollupOptions: {
        output: {
          manualChunks: undefined,
        },
        onwarn(warning, warn) {
          if (warning.code === 'UNUSED_EXTERNAL_IMPORT') return;
          warn(warning);
        }
      }
    },
    ssr: {
      external: ['svgo']
    }
  }
});