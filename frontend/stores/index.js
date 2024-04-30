// ~/store/index.js
import { createPinia } from 'pinia'
import piniaPluginPersistedstate from 'pinia-plugin-persistedstate'

const pinia = createPinia()
pinia.use(piniaPluginPersistedstate)

import { defineStore } from 'pinia'

export const useStore = defineStore({
  id: 'main',
  state: () => ({
    return_path: null,
    user_id: null,
    email: null,
    username: null,
  }),
  actions: {
    save_seats(seats) {
      this.selected_seats = seats;
    },
    save_movie_id(id) {
      this.movie_id = id;
    },
    save_user_info(username, email, id) {
      this.username = username;
      this.email = email;
      this.user_id = id;
    },

    return_user_id() {
      return this.user_id;
    },
    return_user_email() {
      return this.email;
    },
    return_user_username() {
      return this.username;
    },
    return_user_info() {
      return {
        username: this.username,
        email: this.email,
        user_id: this.user_id
      };
    },
    clear_user_info() {
      this.username = null;
      this.email = null;
      this.user_id = null;
    },
    set_return_path(path) {
      this.return_path = path;
    },
    return_path() {
      return this.return_path;
    },


    logout() {
      this.clear_user_info();
    }
  
  },

  persist: true,
},




);