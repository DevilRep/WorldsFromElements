<template>
    <div class="page main">
        <div class="row">
            <div class="col-12 text-right controls-wrapper">
                <progress-component :max="maxRecipes" min="0" ref="progress"></progress-component>
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
            newGameAvailable: false,
            maxRecipes: 0
        }),
        mounted() {
            EventBus.$on('elements:update', this.updateElements);
            EventBus.$on('modal:error:show', error => {
                this.$refs.modal
                    .init({
                        type: 'error',
                        title: 'Error!',
                        message: error.error
                    })
                    .open()
            });
            EventBus.$on('game:check', () =>
                window.axios.get('/api/game')
                    .then(result => {
                        this.newGameAvailable = !result.data.new;
                        this.$refs.progress.set(result.data.progress.current);
                        if (!this.maxRecipes) {
                            this.maxRecipes = result.data.progress.max;
                        }
                        if (!result.data.end) {
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
                    })
                    .catch(error => EventBus.$emit('modal:error:show', error.response.data))
            );
            EventBus.$on('elements:draggable:off', () => this.draggable = false);
            EventBus.$on('elements:draggable:on', () => this.draggable = true);
            EventBus.$on('game:new:on', () => {
                if (this.newGameAvailable) {
                    return;
                }
                this.newGameAvailable = true;
            });
            EventBus.$on('game:new:off', () => {
                if (!this.newGameAvailable) {
                    return;
                }
                this.newGameAvailable = false
            });
            this.all();
            EventBus.$emit('game:check');
        },
        methods: {
            all() {
                window.axios.get('/api/elements')
                    .then(response => {
                        this.updateElements(response.data);
                        EventBus.$emit('elements:draggable:on');
                    })
                    .catch(error => EventBus.$emit('modal:error:show', error.response.data));
            },
            newGame() {
                window.axios.post('/api/game')
                    .then(response => {
                        EventBus.$emit('game:check');
                        this.updateElements(response.data);
                        EventBus.$emit('elements:draggable:on');
                    })
                    .catch(error => EventBus.$emit('modal:error:show', error.response.data));
            },
            updateElements(elements) {
                this.elements = elements;
            }
        }
    }
</script>