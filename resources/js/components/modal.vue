<template>
    <sweet-modal :icon="type" :class="type" :title="title" ref="modal">
        {{ message }}
    </sweet-modal>
</template>

<script>
    import { SweetModal, SweetModalTab } from 'sweet-modal-vue';

    export default {
        data: () => ({
            message: '',
            type: '',
            title: ''
        }),
        methods: {
            init(data) {
                ['type', 'message', 'title'].forEach(element => {
                    if (!data[element]) {
                        return;
                    }
                    this[element] = data[element];
                });
                return this;
            },
            open() {
                this.$refs.modal.open();
            }
        },
        components: {
            SweetModal,
            SweetModalTab
        }
    }
</script>