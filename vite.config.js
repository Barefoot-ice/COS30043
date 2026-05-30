import { defineConfig } from 'vite'
import vue from '@vitejs/plugin-vue'


export default defineConfig(({ mode }) => ({
  plugins: [vue()],
  base: mode === 'production' ? '/cos30043/s105139158/assignment/' : '/',
}))
