// https://nuxt.com/docs/api/configuration/nuxt-config
export default defineNuxtConfig({
  devtools: { enabled: true },
  modules: ['@pinia/nuxt', 'nuxt-socket-io', '@pinia-plugin-persistedstate/nuxt','nuxt-rating'],
  telemetry: false,
  ssr:false,
  routeRules: {
    // Homepage pre-rendered at build time
    '/': { ssr: true },
    
  },
})
  

