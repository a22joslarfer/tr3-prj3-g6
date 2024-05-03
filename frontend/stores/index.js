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
    password: null,
    birthday: null,
    phone: null,
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
    save_user_info_register(username, email, id, phone, birthday, password) {
      this.username = username;
      this.email = email;
      this.user_id = id;
      this.phone = phone;
      this.birthday = birthday;
      this.password = password;
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
    return_user_phone() {
      return this.phone;
    },
    return_user_birthday() {
      return this.birthday;
    },
    return_user_password() {
      return this.password;
    },
    return_user_info() {
      return {
        username: this.username,
        email: this.email,
        user_id: this.user_id,
       

      };
    },
    return_user_info_register() {
      return {
        username: this.username,
        email: this.email,
        user_id: this.user_id,
        phone: this.phone,
        birthday: this.birthday,
        password: this.password,
      };
    },
    clear_user_info() {
      this.username = null;
      this.email = null;
      this.user_id = null;
      this.phone = null;
      this.birthday = null;
      this.password = null;
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