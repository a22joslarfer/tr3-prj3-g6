// ~/store/index.js
import {
  defineStore
} from 'pinia';

export const useStore = defineStore({
  id: 'main',
  state: () => ({
    selected_seats: [],
    user_id: null,
    email: null,
    username: null,
    movie_id: 0,
    date: null,
    is_navigating_to_profile: false,
    isAdmin: false,
  }),
  actions: {
    save_seats(seats) {
      this.selected_seats = seats;
    },
    save_movie_id(id) {
      this.movie_id = id;
    },
    save_movie_date(date) {
      this.date = date;
    },
    save_user_info(username, email, id) {
      this.username = username;
      this.email = email;
      this.user_id = id;
    },
    save_date(date) {
      this.date = date;
    },
    save_is_navigating_to_profile(bool) {
      this.is_navigating_to_profile = bool;
    },
    save_isAdmin(bool) {
      this.isAdmin = bool;
    },
    return_is_navigating_to_profile() {
      return this.is_navigating_to_profile;
    },
    return_selected_seats() {
      return this.selected_seats;
    },
    return_isAdmin() {
      return this.isAdmin;
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
    return_movie_id() {
      return this.movie_id;
    },
    return_movie_date() {
      return this.date;
    },
    reset_booking_info() {
      this.selected_seats = [];
      this.movie_id = null;
      this.user_id = null;
      this.email = null;
      this.username = null;
      this.date = null;
      this.is_navigating_to_profile = false;
      this.isAdmin = false;
    }
  },
});