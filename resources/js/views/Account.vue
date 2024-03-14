<script setup>
import Navbar from "../components/Navbar.vue";
import Footer from "../components/Footer.vue";
import Modal from "../components/Modal.vue";
import axios from "axios";
</script>

<template>
    <Navbar />
    <div class="container d-flex justify-content-center">
        <div
            v-if="spinner"
            class="spinner-border text-warning position-absolute top-50"
            role="status"
        >
            <span class="visually-hidden">Loading...</span>
        </div>
    </div>
    <div class="mt-5 d-flex justify-content-center" v-if="data.role != 'administrator' && data.role != 'korisnik'">
        <div   v-if="!spinner"  class="alert alert-warning text-dark text-center col-12 col-lg-4 col-md-5 col-sm-5" style="background-color: #ffba00;">Nemate pristupa ovoj stranici!</div>
    </div>
    <div class="mt-5" v-else>
        <div
            v-if="data.role === 'administrator'"
            class="position-absoulte start-0 top-0"
        >
            <div>
                <svg
                    xmlns="http://www.w3.org/2000/svg"
                    width="40"
                    height="40"
                    fill="currentColor"
                    class="bi bi-list text-light"
                    viewBox="0 0 16 16"
                    data-bs-toggle="offcanvas"
                    data-bs-target="#offcanvasScrolling"
                    aria-controls="offcanvasScrolling"
                >
                    <path
                        fill-rule="evenodd"
                        d="M2.5 12a.5.5 0 0 1 .5-.5h10a.5.5 0 0 1 0 1H3a.5.5 0 0 1-.5-.5m0-4a.5.5 0 0 1 .5-.5h10a.5.5 0 0 1 0 1H3a.5.5 0 0 1-.5-.5m0-4a.5.5 0 0 1 .5-.5h10a.5.5 0 0 1 0 1H3a.5.5 0 0 1-.5-.5"
                    />
                </svg>
            </div>
        </div>
        <h3 class="text-center text-light">Pozdrav {{ data.firstName }}</h3>
        <h5 class="text-center text-light">Ovo su tvoji detalji računa</h5>
        <div class="container" style="margin-bottom: 100px">
            <div
                class="login-form d-flex justify-content-center align-items-center p-3"
            >
                <form
                    class="col-12 col-sm-12 col-md-10 col-lg-7 mt-1 rounded-3 shadow-sm login-form-details"
                >
                    <div class="d-flex justify-content-center accImg">
                        <img src="../images/logo.png" alt="" />
                    </div>
                    <div class="input-group mb-3">
                        <span class="input-group-text" id="basic-addon1"
                            >Ime</span
                        >
                        <input
                            type="text"
                            class="form-control"
                            :value="data.firstName"
                            aria-label="Username"
                            aria-describedby="basic-addon1"
                            :disabled="true"
                        />
                    </div>

                    <div class="input-group mb-3">
                        <span class="input-group-text" id="basic-addon1"
                            >Prezime</span
                        >
                        <input
                            type="text"
                            class="form-control"
                            :value="data.lastName"
                            aria-label="Username"
                            aria-describedby="basic-addon1"
                            :disabled="true"
                        />
                    </div>

                    <div class="input-group mb-3">
                        <span class="input-group-text" id="basic-addon1"
                            >Email</span
                        >
                        <input
                            type="text"
                            class="form-control"
                            :value="data.email"
                            aria-label="Username"
                            aria-describedby="basic-addon1"
                            :disabled="true"
                        />
                    </div>

                    <div class="input-group mb-3">
                        <span class="input-group-text" id="basic-addon1"
                            >Lozinka</span
                        >
                        <input
                            type="text"
                            class="form-control"
                            :value="data.password"
                            aria-label="Username"
                            aria-describedby="basic-addon1"
                            :disabled="true"
                        />
                    </div>
                    <div class="input-group mb-3">
                        <span class="input-group-text" id="basic-addon1"
                            >Uloga</span
                        >
                        <input
                            type="text"
                            class="form-control"
                            :value="data.role"
                            aria-label="Username"
                            aria-describedby="basic-addon1"
                            :disabled="true"
                        />
                    </div>
                </form>
            </div>
        </div>
    </div>
    <Modal />
    <Footer />
</template>

<script>
export default {
    data() {
        return {
            data: [],
            spinner: true,
        };
    },
    created() {
        this.getData();
    },
    methods: {
        getData() {
            axios
                .get("/getUserData")
                .then((response) => {
                    this.data = response.data.user;
                    console.log(this.data.role);
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
.login-form-details {
    background-color: #282828;
    padding: 2vh !important;
}

@media screen and (max-width: 1700px) {
    .login-form-details {
        background-color: #282828;
        padding: 2vh !important;
    }
}
</style>