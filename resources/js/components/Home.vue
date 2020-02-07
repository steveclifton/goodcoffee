<template>
    <div>
        <h1>home</h1>
        <button @click="getClosest">Use my devices Location</button>
        <div v-if="error">{{error}}</div>
        <div v-if="loading">{{loading}}</div>
        <ul>
            <li v-for="cafe in cafes">
                {{ cafe.distance + 'm' + ' - ' + cafe.name + ', ' + cafe.address}}
            </li>
        </ul>
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
        mounted() {
            console.log('Component mounted.')
        },
    }
</script>
