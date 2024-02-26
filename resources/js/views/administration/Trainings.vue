<script setup>
import Navbar from "../../components/Navbar.vue";
import Footer from "../../components/Footer.vue";
import Modal from "../../components/Modal.vue";
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
    <div v-if="data.role === 'administrator'">
        <div>
        <button
            class="btn float-end mt-3 me-3 btn-warning"
            data-bs-toggle="modal"
            data-bs-target="#exampleModal"
            data-bs-whatever="@mdo"
        >
            Dodaj trening
        </button>

        <div
            class="modal fade"
            id="exampleModal"
            tabindex="-1"
            aria-labelledby="exampleModalLabel"
            aria-hidden="true"
        >
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header bg-dark">
                        <h1
                            class="modal-title fs-5 text-light"
                            id="exampleModalLabel"
                        >
                            Dodaj trening
                        </h1>
                        <button
                            type="button"
                            class="btn-close"
                            data-bs-dismiss="modal"
                            aria-label="Close"
                        ></button>
                    </div>
                    <div class="modal-body bg-dark">
                        <form @submit.prevent="addTraining()" method="POST">
                            <div class="mb-3">
                                <label
                                    for="recipient-name"
                                    class="col-form-label text-light"
                                    >Ime treninga:</label
                                >
                                <input
                                    type="text"
                                    class="form-control"
                                    id="recipient-name"
                                    v-model="training.name"
                                />
                            </div>
                            <div class="mb-3">
                                <label
                                    for="message-text"
                                    class="col-form-label text-light"
                                    >Opis:</label
                                >
                                <textarea
                                    class="form-control"
                                    id="message-text"
                                    v-model="training.description"
                                ></textarea>
                            </div>
                            <div class="mb-3">
                                <label
                                    for="recipient-name"
                                    class="col-form-label text-light"
                                    >Cijena treninga:</label
                                >
                                <input
                                    type="text"
                                    class="form-control"
                                    id="recipient-price"
                                    v-model="training.price"
                                />
                            </div>
                            <label
                                for="formFileSm"
                                class="form-label text-light"
                                >Dodaj sliku
                            </label>
                            <div class="mb-3">
                                <input
                                    class="form-control form-control-sm"
                                    id="formFileSm"
                                    type="file"
                                    @change="imageChange"
                                    required
                                />
                            </div>
                            <button type="submit" class="btn btn-warning w-100">
                                Dodaj
                            </button>
                        </form>
                    </div>
                    <div class="modal-footer bg-dark">
                        <button
                            type="button"
                            class="btn btn-secondary w-100"
                            data-bs-dismiss="modal"
                        >
                            Close
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <div class="container mt-5">
            <h3 class="text-light text-center mt-3 mb-5">Popis svih treninga</h3>
            <table class="table table-striped table-bordered table-dark">
                <thead>
                    <tr>
                        <th scope="col" class="text-center">ID</th>
                        <th scope="col" class="text-center">Ime</th>
                        <th scope="col" class="text-center">Opis</th>
                        <th scope="col" class="text-center">Izbrisi</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="training in trainings">
                        <th scope="row" class="text-center">{{ training.id }}</th>
                        <td class="text-center">{{ training.name }}</td>
                        <td class="text-center">{{ training.description }}</td>
                        <td class="text-center">
                            <button
                                class="btn btn-sm"
                                @click="deleteTraining(training.id)"
                            >
                                <svg
                                    xmlns="http://www.w3.org/2000/svg"
                                    width="25"
                                    height="25"
                                    fill="currentColor"
                                    class="bi bi-person-dash text-danger"
                                    viewBox="0 0 16 16"
                                >
                                    <path
                                        d="M12.5 16a3.5 3.5 0 1 0 0-7 3.5 3.5 0 0 0 0 7M11 12h3a.5.5 0 0 1 0 1h-3a.5.5 0 0 1 0-1m0-7a3 3 0 1 1-6 0 3 3 0 0 1 6 0M8 7a2 2 0 1 0 0-4 2 2 0 0 0 0 4"
                                    />
                                    <path
                                        d="M8.256 14a4.5 4.5 0 0 1-.229-1.004H3c.001-.246.154-.986.832-1.664C4.484 10.68 5.711 10 8 10q.39 0 .74.025c.226-.341.496-.65.804-.918Q8.844 9.002 8 9c-5 0-6 3-6 4s1 1 1 1z"
                                    />
                                </svg>
                            </button>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
    </div>
    <div class="mt-5 d-flex justify-content-center" v-else>
        <div v-if="!spinner" class="alert alert-warning text-dark text-center col-12 col-lg-4 col-md-5 col-sm-5" style="background-color: #ffba00;">Nemate pristupa ovoj stranici!</div>
    </div>
    <Modal />
    <Footer />
</template>

<script>
import axios from "axios";

export default {
    data() {
        return {
            training: {
                name: "",
                description: "",
                image: "",
                price: "",
            },
            csrfToken: "",
            trainings: [],
            users: [],
            data:[],
            spinner:true
        };
    },
    mounted() {
        this.fetchCsrfToken();
    },
    created() {
        this.getTraining();
        this.getUser();
        this.getData();
    },
    methods: {
        imageChange(event) {
            this.training.image = event.target.files[0];
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
        addTraining() {
            let training = new FormData();
            training.append("name", this.training.name);
            training.append("description", this.training.description);
            training.append("image", this.training.image);
            training.append("price", this.training.price);

            axios.defaults.headers.common["X-CSRF-TOKEN"] = this.csrfToken;

            axios
                .post("/addTraining", training)
                .then((response) => {
                    this.message = response.data.message;
                    this.getTraining();
                    $("#exampleModal").modal("hide");
                    this.training = {
                        name: "",
                        description: "",
                        price: "",
                        image: null,
                    };
                })
                .catch((error) => {
                    if (error.response && error.response.status === 422) {
                        this.errors = error.response.data.errors;
                    } else {
                        console.log(error);
                    }
                });
        },
        getTraining() {
            axios
                .get("/getTraining")
                .then((response) => {
                    this.trainings = response.data.trainings;
                    console.log("Lista treninga: ", this.trainings);
                })
                .catch((error) => {
                    console.log(error);
                });
        },

        deleteTraining(id) {
            axios
                .post(`/deleteTraining/${id}`)
                .then((response) => {
                    this.message = response.data.message;
                    this.getTraining();
                })
                .catch((error) => {
                    console.log(error);
                });
        },
        getUser() {
            axios
                .get("/getUsers")
                .then((response) => {
                    this.users = response.data.users;
                    console.log(this.users);
                })
                .catch((error) => {
                    console.log(error);
                });
        },
        getData() {
            axios
                .get("/getUserData")
                .then((response) => {
                    this.data = response.data;
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

<style scoped></style>
