// middleware/admin.js
export default defineNuxtRouteMiddleware((to, from) => {
    const store = useStore();
    const rol = store.return_user_rol();
    
    if (rol != 'admin') {
      return navigateTo('/'); 
    }
  });
  