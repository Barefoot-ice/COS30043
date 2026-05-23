import { defineConfig } from 'vite'
import vue from '@vitejs/plugin-vue'

// https://vite.dev/config/
// export default defineConfig(({ mode }) => ({
//   plugins: [vue()],
//   base: mode === 'production' ? '/cos30043/s105139158/group-project/' : '/',
// }))

export default defineConfig({
  plugins: [vue()],
})