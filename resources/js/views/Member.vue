<script setup>
import Navbar from "../components/Navbar.vue";
import Footer from "../components/Footer.vue";
</script>

<template>
    <Navbar />
    <div
        v-if="succesMember"
        class="alert alert-dark infoMessage col-lg-2 col-xl-2 col-12 float-end ms-3 mt-3 me-3"
        role="alert"
    >
        {{ message }}
    </div>
    <div
        v-if="failedMember"
        class="alert alert-dark infoMessage col-lg-2 col-xl-2 col-12 float-end ms-3 mt-3 me-3"
        role="alert"
    >
        Već ste učlanjeni!
    </div>

    <div v-if="!isLoggedIn">
        <div class="container d-flex justify-content-center">
            <div>
                <div class="alert alert-dark mt-5 infoMessage">
                    Prijavite se kako bi mogli da se uclanite!
                    <router-link  to="/">Prijava</router-link>
                </div>

            </div>
        </div>
    </div>

    <div class="container d-flex justify-content-center">
        <div
            v-if="spinner"
            class="spinner-border text-warning position-absolute top-50"
            role="status"
        >
            <span class="visually-hidden">Loading...</span>
        </div>
    </div>
    <div v-if="isLoggedIn" >
        <div v-if="!spinner">
            <h1 class="text-light text-center mt-3">Učlani se</h1>
            <div class="container-fluid mt-3">
                <div class="container">
                    <div
                        class="login-form d-flex justify-content-center align-items-center"

                    >
                        <form
                            @submit.prevent="registerMember()"
                            method="POST"
                            class="col-12 col-sm-12 col-md-10 col-lg-7 p-5 rounded-3 shadow-sm login-form-details"
                        >
                            <div class="mb-3 d-flex justify-content-center">
                                <img src="../images/logo.png" alt="" />
                            </div>
                            <div class="form-floating mb-3">
                                <input
                                    type="text"
                                    class="form-control"
                                    id="floatingInput"
                                    placeholder="ime"
                                    v-model="member.firstName"
                                />
                                <label for="floatingInput">Ime</label>
                            </div>

                            <div class="form-floating mb-3">
                                <input
                                    type="text"
                                    class="form-control"
                                    id="floatingInput"
                                    placeholder="prezime"
                                    v-model="member.lastName"
                                />
                                <label for="floatingInput">Prezime</label>
                            </div>
                            <div>
                                <select
                                    id="coachSelect"
                                    class="form-select"
                                    aria-label="Default select example"
                                    v-model="member.coach_id"
                                >
                                    <option disabled value="">
                                        Odaberi trenera
                                    </option>
                                    <option
                                        v-for="coach in coaches"
                                        :value="coach.id"
                                    >
                                        {{ coach.firstName }}
                                        {{ coach.lastName }}
                                    </option>
                                </select>
                            </div>
                            <div class="mt-3">
                                <select
                                    class="form-select"
                                    id="trainSelect"
                                    aria-label="Default select example"
                                    v-model="member.training_id"
                                >
                                    <option disabled value="">
                                        Odaberi trening
                                    </option>
                                    <option
                                        v-for="training in trainings"
                                        :value="training.id"
                                    >
                                        {{ training.name }}
                                    </option>
                                </select>
                            </div>

                            <button
                                type="submit"
                                class="btn p-3 w-100 mt-3 login-btn"
                            >
                                Učlani se
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <Footer />
</template>

<script>
import { mapState } from "vuex";
import axios from "axios";
import { mapGetters } from "vuex";

export default {
    data() {
        return {
            member: {
                firstName: "",
                lastName: "",
                coach_id: "",
                training_id: "",
            },
            users: [],
            trainings: [],
            coaches: [],
            spinner: false,
            csrfToken: "",
            message: "",
            succesMember: false,
            failedMember: false,
            isLoggedIn: false,
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
        this.getUser();
        this.getCoaches();
        this.getTraining();
    },
    mounted() {
        this.fetchCsrfToken();
    },
    methods: {
        registerMember() {
            const Member = {
                firstName: this.member.firstName,
                lastName: this.member.lastName,
                coach_id: this.member.coach_id,
                training_id: this.member.training_id,
            };

            axios.defaults.headers.common["X-CSRF-TOKEN"] = this.csrfToken;
            axios
                .post("/addMember", Member)
                .then((response) => {
                    this.message = response.data.message;
                    this.succesMember = true;
                })
                .catch((error) => {
                    if (error.response && error.response.status === 422) {
                        this.errors = error.response.data.errors;
                    } else if (
                        error.response &&
                        error.response.status === 409
                    ) {
                        this.failedMember = true;
                    }
                });
        },
        fetchCsrfToken() {
            axios
                .get("/sanctum/csrf-cookie")
                .then((response) => {
                    this.csrfToken = response.data.csrf_token;
                })
                .catch((error) => {
                    console.error(error);
                });
        },
        getUser() {
            axios
                .get("/getUsers")
                .then((response) => {
                    this.users = response.data;
                })
                .catch((error) => {
                    console.log(error);
                });
        },
        getTraining() {
            this.spinner = true;
            axios
                .get("/getTraining")
                .then((response) => {
                    this.trainings = response.data.trainings;
                    console.log("Lista treninga: ", this.trainings);
                })
                .catch((error) => {
                    console.log(error);
                })
                .finally(() => {
                    this.spinner = false;
                });
        },
        getCoaches() {
            this.spinner = true;
            axios
                .get("/getCoaches")
                .then((response) => {
                    this.coaches = response.data.coaches;
                })
                .catch((error) => {
                    console.log(error);
                })
                .finally(() => {
                    this.spinner = false;
                });
        },
    },
};
</script>

<style scoped>
.infoMessage {
    color: #000;
    background-color: #ffba00;
    border: none;
    text-align: center;
}
.login-form-details {
    background-color: #282828;
    padding: 5vh !important;
}

.login-btn {
    background-color: #ffba00;
    border: none;
}

.login-btn:hover {
    background-color: #ffba00;
    opacity: 0.8;
    border: none;
}
</style>
