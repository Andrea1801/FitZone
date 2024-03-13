<template>
    <div class="container-fluid">
        <div class="container">
        <div
            class="login-form d-flex justify-content-center align-items-center vh-100"
        >
            <form
                @submit.prevent="registerUser()"
                method="POST"
                class="col-12  col-sm-12 col-md-10 col-lg-7 p-5 rounded-3 shadow-sm login-form-details"
            >
            <div class="mb-3 d-flex justify-content-center">
                <img src="../images/logo.png" alt="">
            </div>
                <div class="form-floating mb-3">
                    <input
                        type="text"
                        class="form-control"
                        id="floatingInput"
                        placeholder="ime"
                        v-model="user.firstName"
                    />
                    <label for="floatingInput">Ime</label>
                </div>
                <p v-if="errors.firstName" class="text-danger">
                    {{ errors.firstName[0] }}
                </p>
                <div class="form-floating mb-3">
                    <input
                        type="text"
                        class="form-control"
                        id="floatingInput"
                        placeholder="prezime"
                        v-model="user.lastName"
                    />
                    <label for="floatingInput">Prezime</label>
                </div>
                <p v-if="errors.lastName" class="text-danger">
                    {{ errors.lastName[0] }}
                </p>
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
                <button class="btn p-3 w-100 mt-3 login-btn">Registracija</button>
                <p class="mt-3 text-light text-center">
                    Imas racun?
                    <span
                        ><RouterLink to="/" class="text-warning"
                            >Prijavi se</RouterLink
                        ></span
                    >
                </p>
                <div class="mt-3 alert alert-info infoMessage" v-if="successMessage">
                    {{message}}
                </div>

            </form>
        </div>
    </div>
    </div>

</template>

<script>
import axios from 'axios';


export default{
    data(){
        return{
            user:{
                firstName: '',
                lastName: '',
                email: '',
                password: ''
            },
            csrfToken:'',
            errors:{},
            successMessage:false,
        }
    },
    methods:{
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
        registerUser(){
            const User = {
                firstName: this.user.firstName,
                lastName: this.user.lastName,
                email: this.user.email,
                password: this.user.password,
            };
            axios.defaults.headers.common["X-CSRF-TOKEN"] = this.csrfToken;
            axios
                .post("/registerUser", User)
                .then((response) => {
                    this.message  = response.data.message;
                    this.successMessage = true;
                    setTimeout(() => {
                        this.successMessage = false; 
                    }, 2000);
                    this.user= {
                        firstName: "",
                        lastName: "",
                        email: "",
                        password: "",
                    };
                    this.errors = {};
                })
                .catch((error) => {
                    if (error.response && error.response.status === 422) {
                        this.errors = error.response.data.errors;
                    } else {
                        console.log(error);
                    }
                });
        }
    }
}

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

.infoMessage{
    color:#000;
    background-color: #ffba00;
    border:none;
    text-align: center;
}
</style>
