<template>
    <div class="container">
        <div class="row">
            <div class="col-12 text-right controls-wrapper">
                <button v-if="newGameAvailable" v-on:click="newGame" class="btn btn-outline-primary new-game">New game</button>
            </div>
        </div>
        <div class="row justify-content-center">
            <div class="col-12">
                <element-component
                        v-for="element in elements"
                        :key="element.id"
                        v-bind:item="element"
                        v-bind:draggable="draggable"
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
            elements: [],
            draggable: false,
            newGameAvailable: true
        }),
        mounted() {
            EventBus.$on('elements:update', this.updateElements);
            EventBus.$on('modal:error:show', error =>
                this.$refs.modal
                    .init({
                        type: 'error',
                        title: 'Error!',
                        message: error.response.data.error
                    })
                    .open()
            );
            EventBus.$on('elements:check', end => {
                if (!end) {
                    return;
                }
                this.$refs.modal
                    .init({
                        type: 'success',
                        title: 'Congratulations!',
                        message: 'You won the game! Well done!'
                    })
                    .open();
                EventBus.$emit('elements:draggable:off');
            });
            EventBus.$on('elements:draggable:off', () => this.draggable = false);
            EventBus.$on('elements:draggable:on', () => this.draggable = true);
            EventBus.$on('newGame:on', () => {
                if (this.newGameAvailable) {
                    return;
                }
                this.newGameAvailable = true;
            });
            EventBus.$on('newGame:off', () => {
                if (!this.newGameAvailable) {
                    return;
                }
                this.newGameAvailable = false
            });
            this.all();
        },
        methods: {
            all() {
                window.axios.get('/api/v1/elements')
                    .then(response => {
                        this.updateElements(response.data);
                        EventBus.$emit('elements:draggable:on');
                    })
                    .catch(error => EventBus.$emit('modal:error:show', error));
            },
            newGame() {
                window.axios.post('/api/v1/elements/new-game')
                    .then(response => {
                        EventBus.$emit('newGame:off');
                        this.updateElements(response.data);
                        EventBus.$emit('elements:draggable:on');
                    })
                    .catch(error => EventBus.$emit('modal:error:show', error));
            },
            updateElements(elements) {
                this.elements = elements;
            }
        }
    }
</script>