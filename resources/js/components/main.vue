<template>
    <div class="container">
        <div class="row">
            <div class="col-12 text-right">
                <button v-on:click="newGame" class="btn btn-outline-primary">New game</button>
            </div>
        </div>
        <div class="row justify-content-center">
            <div class="col-12">
                <element-component
                        v-for="element in elements"
                        :key="element.id"
                        v-bind:item="element"
                ></element-component>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        data () {
            return {
                elements: []
            }
        },
        mounted() {
            this.all();
        },
        methods: {
            all() {
                window.axios.get('/api/v1/elements/available')
                    .then(function (response) {
                        this.elements = response.data.items;
                    }.bind(this))
                    .catch(error => {
                        console.log(error);
                    });
            },

            newGame() {
                window.axios.post('/api/v1/elements/new-game')
                    .then(function (response) {
                        this.elements = response.data.items;
                    }.bind(this))
                    .catch(error => {
                        console.log(error);
                    });
            }
        }
    }
</script>