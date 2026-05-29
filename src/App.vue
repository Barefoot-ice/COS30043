<script>
import { api } from "./lib/api";
import { mapState } from "vuex";

export default {
    data: function () {
        return {
            loginErr: null
        };
    },
    computed: mapState(["loggedIn", "user"]),
    methods: {
        async submitLogIn(username, password) {
            let userDetails = null
            try {
                userDetails = await api.getLogin(username, password);
            }
            catch (err) {
                console.error("Failed to load posts:", err);
            }
            if (userDetails && userDetails.length > 0) {
                this.$store.commit("logIn", userDetails[0]);
                this.loginErr = null;
            }
            else {
                this.loginErr = 'Invalid Username or Password'
            }
        },
        submitLogOut: function () {
            this.$store.commit("logOut");
        },
    },
};
</script>

<template>
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary">
        <div class="container">
            <router-link class="navbar-brand" to="/">COS30043 Group Project</router-link>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false"
                aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <router-link class="nav-link" to="/">Home</router-link>
                    </li>
                    <li class="nav-item">
                        <router-link class="nav-link" to="/jobs">Job Listings</router-link>
                    </li>
                    <li class="nav-item">
                        <router-link class="nav-link" to="/FAQ">FAQ</router-link>
                    </li>
                    <li class="nav-item">
                        <router-link class="nav-link" to="/about">About</router-link>
                    </li>
                    <li class="nav-item">
                        <router-link class="nav-link" to="/signup">Sign Up</router-link>
                    </li>
                </ul>
                <div v-if="loggedIn">
                    <span class="navbar-text">Welcome, {{ user.username }}!</span>
                    <button class="btn btn-primary" @click="submitLogOut">
                        Logout
                    </button>
                </div>
                <div v-else>
                    <form class="d-flex" @submit.prevent="submitLogIn($refs.username.value, $refs.password.value)">
                        <input type="text" ref="username" class="form-control" placeholder="Username" />
                        <input type="password" ref="password" class="form-control" placeholder="Password" />
                        <button type="submit" class="btn btn-primary">Login</button>
                    </form>
                    <p class="text-align-end" v-if="loginErr">{{ loginErr }}</p>
                </div>
            </div>
        </div>
    </nav>
    <router-view />
    <footer class="py-5 bg-primary">
        <div class="container">
            <p class="m-0 text-center text-white">
                Copyright &copy; Tuesday 11.30 - Group 1
            </p>
        </div>
    </footer>
</template>
