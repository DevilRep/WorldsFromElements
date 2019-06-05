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
    import EventBus from '../eventBus';

    export default {
        props: ['item', 'draggable'],
        computed: {
            transferData () {
                return this.item.id;
            }
        },
        methods: {
            async makeElement(data) {
                let droppedOn = this.transferData;
                if (droppedOn === data) {
                    return;
                }
                try {
                    EventBus.$emit('loader:show');
                    let result = await window.axios.post('/api/elements', {components: [data, droppedOn]});
                    EventBus.$emit('elements:update', result.data);
                    EventBus.$emit('game:progress');
                    EventBus.$emit('game:new:on');
                    EventBus.$emit('loader:hide');
                } catch (error) {
                    EventBus.$emit('loader:hide');
                    EventBus.$emit('modal:error:show', error.response.data.message);
                }
            }
        }
    }
</script>