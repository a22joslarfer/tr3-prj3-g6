import axios from "axios";
import path from "path";
import cron from 'node-cron';


const getUsers = async () => {
  try {
    const endpoint = 'http://elysium.daw.inspedralbes.cat/backend/public/api/users';
    const { data } = await axios.get(endpoint);
    const users = data;

    return users.map((user: { id: string }) => `/auth/${user.id}`);
  } catch (error) {
    console.error('Failed to fetch user routes:', error);
    return [];
  }
};

const getComentarioRoutes = async () => {
  try {
    const endpoint = 'http://elysium.daw.inspedralbes.cat/backend/public/api/comentarios';
    const { data } = await axios.get(endpoint);
    const comentarios = data;

    return comentarios.map((comentario: { id: string }) => `/comentarios/${comentario.id}`);
  } catch (error) {
    console.error('Failed to fetch comentario routes:', error);
    return [];
  }
};

export default defineNuxtConfig({
  devtools: { enabled: true },
  modules: [
    '@pinia/nuxt', 
    'nuxt-socket-io', 
    '@pinia-plugin-persistedstate/nuxt', 
    'nuxt-rating'
  ],
  telemetry: false,
  alias: {
    'components': path.resolve('components'),
  },
  ssr: false,
  hooks: {
    'nitro:config'(nitroConfig: { prerender: { routes: any[]; }; }) {
      cron.schedule('*/5 * * * *', async () => { // runs every 5 minutes
        if (nitroConfig && nitroConfig.prerender && nitroConfig.prerender.routes) {
          const userRoutes = await getUsers();
          const comentarioRoutes = await getComentarioRoutes();
          nitroConfig.prerender.routes.push(...userRoutes, ...comentarioRoutes);
        }
      });
    }
  }
});