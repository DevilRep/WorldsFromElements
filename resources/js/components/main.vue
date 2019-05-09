<template>
    <div class="container">
        <div class="row">
            <div class="col-12 text-right">
                <button v-on:click="newGame" class="btn btn-outline-primary new-game">New game</button>
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
        <modal-component ref="modal"></modal-component>
    </div>
</template>

<script>
    import { EventBus } from '../eventBus';

    export default {
        data: () => ({
            elements: []
        }),
        mounted() {
            EventBus.$on('elements:update', this.updateElements);
            EventBus.$on('modal:error:show', error => {
                this.$refs.modal
                    .init({
                        icon: 'error',
                        title: 'Error!',
                        message: error.response.data.error
                    })
                    .open();
            });
            this.all();
        },
        methods: {
            all() {
                window.axios.get('/api/v1/elements')
                    .then(response => this.updateElements(response.data))
                    .catch(error => EventBus.$emit('modal:error:show', error));
            },
            newGame() {
                window.axios.post('/api/v1/elements/new-game')
                    .then(response => this.updateElements(response.data))
                    .catch(error => EventBus.$emit('modal:error:show', error));
            },
            updateElements(elements) {
                this.elements = elements;
            }
        }
    }
</script>