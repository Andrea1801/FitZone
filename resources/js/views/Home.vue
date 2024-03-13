<script setup>
import Navbar from "../components/Navbar.vue";
import Footer from '../components/Footer.vue';
</script>

<template>
    <Navbar />

    <div class="info">
        <div class="d-flex flex-column align-items-start ms-5 me-5">
            <img src="../images/logo.png" alt="" class="mt-2" />
            <p class="text-light col-12 col-lg-9 col-xl-6 mt-3 fs-5">
                Fitness je stanje optimalnog fizičkog i mentalnog blagostanja,
                postignuto redovitom tjelovježbom i uravnoteženom prehranom.
                Obuhvaća snagu, fleksibilnost, izdržljivost i opću zdravstvenu
                kondiciju. Održavanje tjelesne kondicije može povećati
                energetske razine, smanjiti rizik od kroničnih bolesti i
                poboljšati kvalitetu života!
            </p>
            <a href="/"  class="btn btn-warning mt-1 col-lg-2 col-md-3 col-sm-3 col-12 text-">Kreni</a>


            <div
                class="d-flex justify-content-between col-12 col-xl-3 col-lg-5 mt-3 gym-items"
            >
                <div>
                    <h1 class="text-warning">4k</h1>
                    <p class="text-warning " >Klijenata</p>
                </div>
                <br>
                <div>
                    <h1 class="text-warning">3.4k+</h1>
                    <p class="text-warning">Zadovoljnih klijenata</p>
                </div>
                <div>
                    <h1 class="text-warning">3k+</h1>
                    <p class="text-warning">Odličnih rezultata</p>
                </div>
            </div>
        </div>
    </div>
    <br />
    <br />
    <br />
    <div class="mt-3">
        <h1 class="text-light text-center mt-2 animateText"><span class="text-warning">KRENI</span> ZDRAVO!</h1>
    </div>
    <Footer/>
</template>

<script>
export default {

};
</script>

<style scoped>
.info {
    position: relative;
    background-image: url("../images/home_cover.jpg");
    height: 500px;
    background-repeat: no-repeat;
    background-size: cover;
    z-index: 0;

}

.info::after {
    content: "";
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background-color: rgba(0, 0, 0, 0.3);
    z-index: -1;
}

.animateText {
    opacity: 1;
    transition: opacity 0.5s ease-in-out;
    letter-spacing: 15px;
    font-size: 5em;
}

.animateText {
    animation: fadeInText 2s forwards infinite;
}
.text-warning{
    text-align:center;
}
@keyframes fadeInText {
    from {
        opacity: 0;
    }
    to {
        opacity: 1;
    }
}

@media screen and (max-width: 768px) {
    .info p{
        font-size: 16px !important;
    }

    .animateText{
        font-size: 25px;
    }

    .gym-items h1{
        font-size: 20px;
        margin-left: 20px;
    }

    .gym-items p{
        font-size: 15px !important;
        margin-left: 15px;
    }
}

@media screen and (max-width: 1700px) {

    .info{
        height: 450px;
        overflow-y: hidden !important;
    }
    .animateText{
        position: relative;
        bottom: 50px;
        font-size: 50px;
    }
}



</style>
