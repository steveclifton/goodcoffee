<template>
    <div class="page-wrap">

        <div class="top-half-page">

            <div class="nav">
                <a class="instagram" href=""><i class="fab fa-instagram"></i></a>
                <a class="login" href="">Login / Sign Up</a>
            </div>

            <div class="top-half-page-inner">


                <img class="coffee animated bounceInDown" src="images/coffee.svg" alt="">
                <h1 class="s-heading-1 u-align-center u-pt-20 u-mt-0">find good coffee nz</h1>

                <div class="search-wrap u-m-auto">
                    <div class="search-bar u-pos-relative">
                        <input class="search-input u-block u-m-auto" type="text" placeholder="Search..">
                        <button @click="getClosest">Find closest!</button>
                    </div>
                </div>
            </div>
        </div>

        <div class="bottom-half-page">
            <h2 class="u-text-brand u-align-center u-pt-20 u-text-darker">Near Me</h2>

            <div class="near-me-items">

                <div class="item" v-for="cafe in cafes">
                    <a href="">
                        <div class="item-inner u-pos-relative">
                            <img src="images/coffeeimg.jpg" alt="">
                            <div class="overlay u-pos-absolute">
                                <div class="top-row">
                                    <div class="reviews">29 Reviews</div>
                                    <div class="rating">4.5</div>
                                </div>
                                <div class="bottom-row">
                                    <h3 class="name u-pb-10">{{cafe.name}}</h3>
                                    <div class="bean u-pb-5">Bean: Allpress</div>
                                    <div class="distance">Distance {{cafe.distance}}</div>
                                </div>
                            </div>
                        </div>
                    </a>
                </div>

            </div>
        </div>

    </div>
</template>

<script>
    export default {
        data() {
            return {
                cafes: go_cafes,
                error: null,
                loading: null

            }
        },
        methods: {
            getClosest: function() {
                // Need to get the users location to get cafes near by
                if (navigator.geolocation) {

                    navigator.geolocation.getCurrentPosition(
                        position => {
                            this.loading = 'Please wait...';

                            axios.post('/api/getlocalcafes', {
                                latitude: position.coords.latitude,
                                longitude: position.coords.longitude,
                            })
                            .then(response => {

                                if (typeof response.data === 'object') {
                                    this.cafes = response.data
                                }
                                this.loading = null;
                            });
                        },
                        error => {
                            this.error = 'Please allow location services to find good coffee!';
                        }
                    );

                }
                else {
                    this.error = 'Please allow location services to find good coffee!';
                }
            }
        },
        created() {
            let pckry = new Packery('.grid', {
                // options
                itemSelector: '.grid-item',
                gutter: 10
            });
        },
    }
</script>
