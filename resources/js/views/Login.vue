<template>
    <div class="container-fluid">
        <div class="container">
            <div
                class="login-form d-flex justify-content-center align-items-center vh-100"
            >
                <form
                    @submit.prevent="loginUser()"
                    method="POST"
                    class="col-12 col-sm-12 col-md-10 col-lg-7 p-5 rounded-3 shadow-sm login-form-details"
                >
                    <div class="mb-3 d-flex justify-content-center">
                        <img src="../images/logo.png" alt="" />
                    </div>
                    <div class="form-floating mb-3">
                        <input
                            type="email"
                            class="form-control"
                            id="floatingInput"
                            placeholder="name@example.com"
                            v-model="user.email"
                        />
                        <label for="floatingInput">Email</label>
                    </div>
                    <p v-if="errors.email" class="text-danger">
                        {{ errors.email[0] }}
                    </p>
                    <div class="form-floating">
                        <input
                            type="password"
                            class="form-control"
                            id="floatingPassword"
                            placeholder="Password"
                            v-model="user.password"
                        />
                        <label for="floatingPassword">Lozinka</label>
                    </div>
                    <p v-if="errors.password" class="text-danger">
                        {{ errors.password[0] }}
                    </p>
                    <button class="btn p-3 w-100 mt-3 login-btn">
                        Prijava
                    </button>
                    <p class="mt-3 text-light text-center">
                        Nemaš racun?
                        <span
                            ><RouterLink to="/register" class="text-warning"
                                >Registriraj se</RouterLink
                            ></span
                        >
                    </p>
                    <div class="d-flex justify-content-center">
                        <router-link class="text-center text-light" to="/home"
                            >Pogledaj kao gost</router-link
                        >
                    </div>

                    <div
                        class="mt-3 alert alert-info infoMessage text-center"
                        v-if="falseLogin"
                    >
                        Prijava nije uspjesna!
                    </div>
                </form>
            </div>
        </div>
    </div>
</template>

<script>
import axios from "axios";
import { onMounted, onUnmounted } from "vue";

export default {
    data() {
        return {
            user: {
                email: "",
                password: "",
            },
            csrfToken: "",
            errors: {},
            successLogin: false,
            falseLogin: false,
        };
    },
    methods: {
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

        loginUser() {
            const User = {
                email: this.user.email,
                password: this.user.password,
            };
            axios.defaults.headers.common["X-CSRF-TOKEN"] = this.csrfToken;
            axios
                .post("/loginUser", User)
                .then((response) => {
                    this.logMessage = response.data.message;

                    this.successLogin = true;
                    if (this.logMessage == "Uspjesna prijava") {

                        this.successLogin = true;
                        this.falseLogin = false;
                        this.$router.push("/home");
                    } else {
                        this.falseLogin = true;
                        this.successLogin = false;
                    }
                })
                .catch((error) => {
                    console.log("Error:", error);
                    if (error.response && error.response.status === 422) {
                        this.errors = error.response.data.errors;
                    } else {
                        console.log(error);
                    }
                });
        },
    },
    mounted() {
        this.fetchCsrfToken();
    },
};
</script>

<style scoped>
.container-fluid {
    background-image: url("../images/login_back_2.jpg");
    background-size: cover;
    background-repeat: no-repeat;
}

.container-fluid::after {
    content: "";
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background-color: rgba(0, 0, 0, 0.5);
    z-index: -1;
}

.login-form-details {
    background-color: #282828;
    padding: 7vh !important;
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

.infoMessage {
    color: #000;
    background-color: #ffba00;
    border: none;
    text-align: center;
}
</style>
