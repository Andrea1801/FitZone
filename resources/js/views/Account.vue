<script setup>
import Navbar from "../components/Navbar.vue";
import Footer from "../components/Footer.vue";
import Modal from "../components/Modal.vue";
import axios from "axios";
</script>

<template>
    <Navbar />
    <div>
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
        <div class="container">
            <div
                class="login-form d-flex justify-content-center align-items-center"
            >
                <form
                    class="col-12 col-sm-12 col-md-10 col-lg-7 mt-1 rounded-3 shadow-sm login-form-details"
                >
                    <div class=" d-flex justify-content-center accImg">
                        <img src="../images/logo.png" alt="" />
                    </div>
                    <div class="mb-2">
                        <label for="floatingInput" class="text-light">Ime</label>
                        <input
                            type="text"
                            class="form-control"
                            id="floatingInput"
                            placeholder="ime"
                            :value="data.firstName"
                            disabled
                        />

                    </div>
                    <label for="floatingInput" class="text-light">Prezime</label>
                    <div class="mb-2">
                        <input
                            type="text"
                            class="form-control"
                            id="floatingInput"
                            placeholder="prezime"
                            :value="data.lastName"
                            disabled
                        />

                    </div>

                    <div class="mb-2">
                        <label for="floatingInput" class="text-light">Email</label>
                        <input
                            type="email"
                            class="form-control"
                            id="floatingInput"
                            placeholder="name@example.com"
                            :value="data.email"
                            disabled
                        />

                    </div>

                    <div class="mb-2">
                        <label for="floatingPassword" class="text-light"
                            >Lozinka</label
                        >
                        <input
                            type="password"
                            class="form-control"
                            id="floatingPassword"
                            placeholder="Password"
                            value="********"
                            disabled
                        />
                    </div>
                    <div>
                        <label for="floatingPassword" class="text-light"
                            >Uloga</label
                        >
                        <input
                            type="text"
                            class="form-control"
                            id="floatingPassword"
                            placeholder="role"
                            :value="data.role"
                            disabled
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
                    this.data = response.data;
                    console.log(this.data.role);
                })
                .catch((error) => {
                    console.log(error);
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
