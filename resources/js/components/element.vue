<template>
    <drop class="dropzone" @drop="makeElement">
        <drag class="drag" :transfer-data="transferData" :draggable="draggable">
            <div class="card element">
                <div class="card-body">
                    <p class="card-text">{{ item.name }} ({{ item.id }})</p>
                </div>
            </div>
        </drag>
    </drop>
</template>

<script>
    import { EventBus } from '../eventBus';

    export default {
        props: ['item', 'draggable'],
        computed: {
            transferData () {
                return this.item.id;
            }
        },
        methods: {
            makeElement(data) {
                let droppedOn = this.transferData;
                if (droppedOn === data) {
                    return;
                }
                window.axios.post('/api/v1/elements', { components: [data, droppedOn] })
                    .then(result => {
                        EventBus.$emit('elements:update', result.data.elements);
                        EventBus.$emit('elements:check', result.data.end);
                        EventBus.$emit('newGame:on');
                    })
                    .catch(error => EventBus.$emit('modal:error:show', error))
            }
        }
    }
</script>