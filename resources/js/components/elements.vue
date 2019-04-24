<template>
    <div class="list-elements">
        <element-component
                v-for="element in elements"
                :key="element.id"
                v-bind:item="element"
        ></element-component>
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
            }
        }
    }
</script>