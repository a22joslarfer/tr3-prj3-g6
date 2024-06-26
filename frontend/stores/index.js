// ~/store/index.js
import { createPinia } from 'pinia'
import piniaPluginPersistedstate from 'pinia-plugin-persistedstate'

const pinia = createPinia()
pinia.use(piniaPluginPersistedstate)

import { defineStore } from 'pinia'

export const useStore = defineStore({
  id: 'main',
  state: () => ({
    path: '/',
    user_id: null,
    email: null,
    password: null,
    birthdate: null,
    phone: null,
    username: null,
    profile_picture: null,
    chattingWithId: null,
    chattingWithIdName: null,
    rol: null,
    nuevaHoraNotificacion: null,

  }),
  actions: {
    guardarNuevaHora(nuevaHora) {
      this.nuevaHoraNotificacion = nuevaHora;
    },
    return_nueva_hora(){
      return this.nuevaHoraNotificacion;
    },
    set_chattingWithId(id) {
      this.chattingWithId = id;
    },
    set_chattingWithIdName(name) {
      this.chattingWithIdName = name;
    },
    return_chattingWithId() {
      return this.chattingWithId;
    },
    return_chattingWithIdName() {
      return this.chattingWithIdName;
    },
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
    save_user_info_register(username, email, id, phone, birthdate) {
      this.username = username;
      this.email = email;
      this.user_id = id;
      this.phone = phone;
      this.birthdate = birthdate;

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
    return_user_profile_picture() {
      return this.profile_picture;
    },
    return_user_info() {
      return {
        username: this.username,
        email: this.email,
        user_id: this.user_id,
        profile_picture: this.profile_picture,

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
      this.user_id = null;
      this.email = null;
      this.password = null;
      this.birthdate = null;
      this.phone = null;
      this.username = null;
      this.profile_picture = null;
      this.chattingWithId = null;
      this.chattingWithIdName = null;
      this.rol = null;
      this.path = '/';
    },
    set_return_path(path) {
      this.path = path;
    },
    return_path() {
      return this.path;
    },
    return_user_rol() {
      return this.rol;
    },
    set_user_rol(rol) {
      this.rol = rol;
    },

    logout() {
      this.clear_user_info();
    }

  },

  persist: true,
},




);