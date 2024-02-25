<script setup>
import Navbar from "../../components/Navbar.vue";
import Footer from "../../components/Footer.vue";
import Modal from "../../components/Modal.vue";
</script>

<template>
    <Navbar />
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
    <div>
        <h3 class="text-light text-center mt-5">Popis svih članova</h3>
        <div class="container mt-5">
            <div class="table-responsive">
                <table class="table table-striped table-bordered table-dark">
                    <thead>
                        <tr>
                            <th scope="col" class="text-center">ID</th>
                            <th scope="col" class="text-center">Ime</th>
                            <th scope="col" class="text-center">Prezime</th>
                            <th scope="col" class="text-center">Email</th>
                            <th scope="col" class="text-center">Uloga</th>
                            <th scope="col" class="text-center">Trening</th>
                            <th scope="col" class="text-center">Trener</th>
                            <th scope="col" class="text-center">Izbrisi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="clan in members">
                            <th scope="row" class="text-center">{{ clan.id }}</th>
                            <td class="text-center">{{ clan.user.firstName }}</td>
                            <td class="text-center">{{ clan.user.lastName }}</td>
                            <td class="text-center">{{ clan.user.email }}</td>
                            <td class="text-center">{{ clan.user.role }}</td>
                            <td class="text-center">{{ clan.training.name }}</td>
                            <td class="text-center">
                                {{ clan.coach.firstName }}
                                {{ clan.coach.lastName }}
                            </td>
                            <td class="text-center">
                                <button
                                    class="btn btn-sm"
                                    @click="deleteMember(clan.id)"
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
    <Modal />
    <Footer />
</template>

<script>
export default {
    data() {
        return {
            members: [],
            users: [],
            data:[]
        };
    },
    created() {
        this.getMembers();
        this.getUser();
        this.getData();
    },
    methods: {
        getMembers() {
            axios
                .get("/getMembers")
                .then((response) => {
                    this.members = response.data.members;
                    console.log(this.members);
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

        deleteMember(id) {
            axios
                .post(`/deleteMember/${id}`)
                .then((response) => {
                    this.message = response.data.message;
                    this.getMembers();
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
                });
        },
    },
};
</script>

<style scoped></style>
