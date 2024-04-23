// ~/store/index.js
import {defineStore} from 'pinia';

export const useStore = defineStore({
    id: 'main',
    state: () => ({
        user_id: null,
        email: null,
        username: null,
        isAdmin: false,
    }),
    actions: {

        save_user_info(username, email, id) {
            this.username = username;
            this.email = email;
            this.user_id = id;
        },

        save_isAdmin(bool) {
            this.isAdmin = bool;
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

        reset_booking_info() {
            this.user_id = null;
            this.email = null;
            this.username = null;
            this.isAdmin = false;
        }
    },
});