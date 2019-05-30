<template>
    <div class="page game">
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
    </div>
</template>

<script>
    import EventBus from '../eventBus';

    export default {
        data: () => ({
            elements: [],
            draggable: false,
            newGameAvailable: false,
            maxRecipes: 0
        }),
        mounted() {
            EventBus.$on('elements:update', this.updateElements);
            EventBus.$on('game:progress', this.progress);
            EventBus.$on('elements:draggable:off', () => this.draggable = false);
            EventBus.$on('elements:draggable:on', () => this.draggable = true);
            EventBus.$on('game:new:on', this.enableNewGame);
            EventBus.$on('game:new:off', this.disableNewGame);

            EventBus.$emit('game:progress');
            this.all();
        },
        methods: {
            all() {
                window.axios.get('/api/elements')
                    .then(response => {
                        this.updateElements(response.data);
                        EventBus.$emit('elements:draggable:on');
                    })
                    .catch(error => EventBus.$emit('modal:error:show', error.response.data.message));
            },
            newGame() {
                window.axios.post('/api/game')
                    .then(response => {
                        EventBus.$emit('game:progress');
                        this.updateElements(response.data);
                        EventBus.$emit('elements:draggable:on');
                    })
                    .catch(error => EventBus.$emit('modal:error:show', error.response.data.message));
            },
            updateElements(elements) {
                this.elements = elements;
            },
            progress() {
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
                        EventBus.$emit('modal:message:show', {
                            type: 'success',
                            title: 'Congratulations!',
                            message: 'You won the game! Well done!'
                        });
                        EventBus.$emit('elements:draggable:off');
                    })
                    .catch(error => EventBus.$emit('modal:error:show', error.response.data.message))
            },
            enableNewGame() {
                if (this.newGameAvailable) {
                    return;
                }
                this.newGameAvailable = true;
            },
            disableNewGame() {
                if (!this.newGameAvailable) {
                    return;
                }
                this.newGameAvailable = false;
            }
        }
    }
</script>