import { defineConfig } from "vite";
import vue from "@vitejs/plugin-vue";
import vuetify from 'vite-plugin-vuetify';
// https://vite.dev/config/
export default defineConfig(({ mode }) => ({
  plugins: [vue(), vuetify({ autoImport: true })],
    base: mode === 'production' ? '/cos30043/s105139158/assignment/' : '/',
}))
