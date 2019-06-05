<template>
    <div class="page game">
        <div class="row">
            <div class="col-12 text-right controls-wrapper">
                <vue-progress :max="maxRecipes" min="0" ref="progress"></vue-progress>
            </div>
        </div>
        <div class="row justify-content-center">
            <div class="col-12">
                <vue-element
                        v-for="element in elements"
                        :key="element.id"
                        v-bind:item="element"
                        v-bind:draggable="draggable"
                ></vue-element>
            </div>
        </div>
    </div>
</template>

<script>
    import EventBus from '../eventBus';
    import ErrorHandler from '../mixins/error';

    export default {
        mixins: [ErrorHandler],
        data: () => ({
            elements: [],
            draggable: false,
            maxRecipes: 0
        }),
        mounted() {
            EventBus.$on('elements:update', this.updateElements);
            EventBus.$on('game:progress', this.progress);
            EventBus.$on('elements:draggable:off', () => this.draggable = false);
            EventBus.$on('elements:draggable:on', () => this.draggable = true);
            EventBus.$on('game:new', this.newGame);

            EventBus.$emit('user:info');
            EventBus.$emit('game:progress');
            this.all();
        },
        methods: {
            async all() {
                try {
                    EventBus.$emit('loader:show');
                    let response = await window.axios.get('/api/elements');
                    this.updateElements(response.data);
                    EventBus.$emit('elements:draggable:on');
                    EventBus.$emit('loader:hide');
                } catch(error) {
                    EventBus.$emit('loader:hide');
                    this.errorHandler(error);
                }
            },
            async newGame() {
                try {
                    EventBus.$emit('loader:show');
                    let response = await window.axios.post('/api/game');
                    EventBus.$emit('game:progress');
                    EventBus.$emit('elements:draggable:on');
                    EventBus.$emit('game:new:off');
                    this.updateElements(response.data);
                    EventBus.$emit('loader:hide');
                } catch (error) {
                    EventBus.$emit('loader:hide');
                    this.errorHandler(error);
                }
            },
            updateElements(elements) {
                this.elements = elements;
            },
            async progress() {
                try {
                    let result = await window.axios.get('/api/game');
                    if (result.data.new) {
                        EventBus.$emit('game:new:off');
                    } else {
                        EventBus.$emit('game:new:on');
                    }
                    if (this.$refs.progress) {
                        this.$refs.progress.set(result.data.progress.current);
                        if (!this.maxRecipes) {
                            this.maxRecipes = result.data.progress.max;
                        }
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
                } catch (error) {
                    this.errorHandler(error);
                }
            }
        }
    }
</script>