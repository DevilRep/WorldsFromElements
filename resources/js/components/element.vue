<template>
    <drop class="dropzone" @drop="makeElement">
        <drag :transfer-data="transferData">
            <div class="card element">
                <div class="card-body">
                    <p class="card-text">{{ item.name }}</p>
                </div>
            </div>
        </drag>
    </drop>
</template>

<script>
    export default {
        props: ['item'],
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
                let components = [
                    data,
                    droppedOn
                ];
                window.axios.post('/api/v1/elements', {
                    components: components
                })
                    .then(result => {
                        debugger;
                        this.$emit('elements:update', result.data);
                    })
            }
        }
    }
</script>