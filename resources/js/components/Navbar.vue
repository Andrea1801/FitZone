<script setup>
import { RouterLink, RouterView } from "vue-router";
</script>

<template>
    <div>
        <nav class="navbar navbar-expand-lg navBar">
            <div class="container-fluid">
                <img
                    src="../images/nav_logo.png"
                    height="30px"
                    width="100px"
                    alt=""
                />
                <button
                    class="navbar-toggler border-light shadow-none"
                    type="button"
                    data-bs-toggle="collapse"
                    data-bs-target="#navbarSupportedContent"
                    aria-controls="navbarSupportedContent"
                    aria-expanded="false"
                    aria-label="Toggle navigation"
                >
                    <svg
                        xmlns="http://www.w3.org/2000/svg"
                        width="35"
                        height="35"
                        fill="currentColor"
                        class="bi bi-list text-light"
                        viewBox="0 0 16 16"
                    >
                        <path
                            fill-rule="evenodd"
                            d="M2.5 12a.5.5 0 0 1 .5-.5h10a.5.5 0 0 1 0 1H3a.5.5 0 0 1-.5-.5m0-4a.5.5 0 0 1 .5-.5h10a.5.5 0 0 1 0 1H3a.5.5 0 0 1-.5-.5m0-4a.5.5 0 0 1 .5-.5h10a.5.5 0 0 1 0 1H3a.5.5 0 0 1-.5-.5"
                        />
                    </svg>
                </button>
                <div
                    class="collapse navbar-collapse"
                    id="navbarSupportedContent"
                >
                    <ul class="navbar-nav me-auto ms-auto mb-2 mb-lg-0">
                        <li class="nav-item">
                            <RouterLink to="/home" class="nav-link text-light"
                                >Fitzone</RouterLink
                            >
                        </li>
                        <li class="nav-item">
                            <RouterLink
                                to="/services"
                                class="nav-link text-light"
                                >Treneri</RouterLink
                            >
                        </li>
                        <li class="nav-item">
                            <RouterLink class="nav-link text-light" to="/member"
                                >Članarine</RouterLink
                            >
                        </li>
                        <li class="nav-item">
                            <RouterLink
                                class="nav-link text-light"
                                to="/categories"
                                >Treninzi</RouterLink
                            >
                        </li>
                    </ul>
                    
                   
                    <ul class="navbar-nav">
                        <li class="nav-item dropdown" v-if="isLoggedIn">
                            <a
                                class="nav-link dropdown-toggle text-light"
                                href="#"
                                id="navbarDropdown"
                                role="button"
                                data-bs-toggle="dropdown"
                                aria-expanded="false"
                            >
                                {{ data.firstName }}
                            </a>
                            <ul
                                class="dropdown-menu dropdown-menu-end"
                                aria-labelledby="navbarDropdown"
                            >
                                <li>
                                    <RouterLink
                                        to="/account"
                                        class="dropdown-item"
                                    >
                                        Račun
                                    </RouterLink>
                                </li>
                                <li>
                                    <a
                                        @click="logout()"
                                        class="dropdown-item"
                                        href="#"
                                    >
                                        Odjava
                                    </a>
                                </li>
                            </ul>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>
    </div>
    <RouterView />
</template>

<script>
import { mapState } from "vuex";
import axios from "axios";
import { mapGetters } from "vuex";

export default {
    data() {
        return {
            isLoggedIn: false,
            searchText: "",
            data:[],
        };
    },


    created() {
        this.getData();
    },
    methods: {

        logout() {
            axios
                .post("/logout")
                .then((response) => {
                    this.isLoggedIn = false;


                    this.$router.push("/");
                })
                .catch((error) => {
                    console.log(error);
                });
        },

        searchItems() {
            axios
                .get("/search", { params: { searchText: this.searchText } })
                .then((response) => {
                    const results = response.data.results;
                    this.search = true;
                    console.log(results);

                    this.$router.push({
                        name: "search",
                        query: { results: JSON.stringify(results) },
                    });
                })
                .catch((error) => {
                    console.log(error);
                });
        },
        getData() {
            axios
                .get("/getUserData")
                .then((response) => {
                    this.data = response.data.user;
                    if(this.data == null){
                        this.isLoggedIn = false;
                    }else{
                        this.isLoggedIn = true;
                    }
                    console.log("Prijavljen je", this.data);
                })
                .catch((error) => {
                    console.log(error);
                }).finally(() => {
                    this.spinner = false;
                });
        },
    },
};
</script>

<style scoped>
.navBar {
    background-color: #282828;
}

.searchBar {
    border: 1px solid #ffba00;
    background-color: #282828;
    outline: none !important;
    color: #fff;
    padding: 3px;
    border-radius: 15px;
}

.searchBar::placeholder {
    color: #fff;
    padding-left: 10px;
}
</style>
