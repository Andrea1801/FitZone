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
                    <form
                        class="d-flex"
                        role="search"
                        @submit.prevent="searchItems"
                    >
                        <input
                            class="form-control me-2 searchBar shadow-none"
                            type="search"
                            placeholder="Pretrazi..."
                            aria-label="Search"
                            v-model="searchText"
                        />
                        <div>
                            <svg
                                xmlns="http://www.w3.org/2000/svg"
                                width="24"
                                height="24"
                                fill="currentColor"
                                class="bi bi-search text-warning mt-1 me-3"
                                viewBox="0 0 16 16"
                            >
                                <path
                                    d="M11.742 10.344a6.5 6.5 0 1 0-1.397 1.398h-.001q.044.06.098.115l3.85 3.85a1 1 0 0 0 1.415-1.414l-3.85-3.85a1 1 0 0 0-.115-.1zM12 6.5a5.5 5.5 0 1 1-11 0 5.5 5.5 0 0 1 11 0"
                                />
                            </svg>
                        </div>
                    </form>
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
                                {{ loggedInUser.firstName }}
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
        };
    },

    computed: {
        ...mapState(["loginMessage"]),
        ...mapGetters(["loggedInUser"]),
        isLoggedIn() {
            return this.loggedInUser !== null;
        },
    },
    created() {
        if (this.loginMessage) {
            setTimeout(() => {
                this.$store.commit("setLoginMessage", "");
            }, 2000);
        }
    },
    methods: {
        checkLoginStatus() {
            axios
                .get("/isLogged")
                .then((response) => {
                    this.loggedInUser = response.data;

                    this.isLoggedIn = true;
                    console.log(this.isLoggedIn);
                })
                .catch((error) => {
                    console.log(error);
                });
        },
        logout() {
            axios
                .post("/logout")
                .then((response) => {
                    this.isLoggedIn = false;
                    this.loggedInUser = null;
                    this.$store.dispatch("logout");
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
