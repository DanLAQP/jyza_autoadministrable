import { defineConfig } from 'astro/config';
import tailwind from "@astrojs/tailwind";
import react from "@astrojs/react";
import node from "@astrojs/node";

export default defineConfig({
  output: 'server',
  adapter: node({ mode: 'standalone' }),
  site: process.env.SITE_URL || 'https://ginecologiajyza.pe',
  integrations: [tailwind(), react()],
  vite: {
    build: {
      minify: 'terser',
      cssCodeSplit: false,
      cssMinify: true,
      terserOptions: {
        compress: { drop_console: true, drop_debugger: true },
        output: { comments: false },
      },
      rollupOptions: {
        output: { manualChunks: undefined },
        onwarn(warning, warn) {
          if (warning.code === 'UNUSED_EXTERNAL_IMPORT') return;
          warn(warning);
        }
      }
    },
    ssr: { external: ['svgo'] }
  }
});
