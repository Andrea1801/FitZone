<script setup>
import Navbar from "../components/Navbar.vue";
import Footer from "../components/Footer.vue";
</script>

<template>
    <Navbar />
    <div>
        <h2 class="text-center text-light mt-5">Rezultati pretrage:</h2>

        <div class="card ms-5" v-for="result in searchResults" :key="result.id" style="width: 18rem">
            <img :src="getImageUrl(result.image)" alt="" />
            <div class="card-body bg-dark">
                <h5 class="card-title text-light">Ime: {{ result.firstName }}</h5>
                <hr  class="text-light">
                <p class="card-text text-light">
                    Opis trenera: {{ result.description }}
                </p>
                <hr class="text-light">
                <a href="#" class="btn btn-outline-warning">Kontakt:{{result.email}}</a>
            </div>
        </div>
    </div>
    <Footer />
</template>

<script>
export default {
    data() {
        return {
            searchResults: [],
        };
    },
    mounted() {
        this.searchResults = JSON.parse(this.$route.query.results);

    },

    methods: {
        getImageUrl(imageName) {
            return `/images/${imageName}`;
        },

    },



};
</script>

<style scoped></style>
