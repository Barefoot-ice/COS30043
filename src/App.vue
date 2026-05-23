<script>
import { mapState } from "vuex";
import { api } from "./lib/api";

console.log(await api.getJobs().then(res => res.json()))


export default {
    data: function () {
        return {
            nameInput: null,
        };
    },
    computed: mapState(["loggedIn", "user"]),
    methods: {
        submitLogIn: function () {
            this.$store.commit("logIn", this.nameInput);
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
                        <router-link class="nav-link" to="/FAQ">FAQ</router-link>
                    </li>
                    <li class="nav-item">
                        <router-link class="nav-link" to="/signup">Sign Up</router-link>
                    </li>
                </ul>
                <div v-if="loggedIn">
                    <span class="navbar-text">Welcome, {{ user.firstName }}!</span>
                    <button class="btn btn-primary" @click="submitLogOut">
                        Logout
                    </button>
                </div>
                <div v-else>
                    <form class="d-flex">
                        <input type="text" class="form-control" placeholder="Username" v-model="nameInput" />
                        <input type="text" class="form-control" placeholder="Password" />
                        <button class="btn btn-primary" @click="submitLogIn">
                            Login
                        </button>
                    </form>
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
