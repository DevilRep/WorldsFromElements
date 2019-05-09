<template>
    <sweet-modal :icon="icon" :title="title" ref="modal">
        {{ message }}
    </sweet-modal>
</template>

<script>
    import { SweetModal, SweetModalTab } from 'sweet-modal-vue';

    export default {
        data: () => ({
            message: '',
            icon: '',
            title: ''
        }),
        methods: {
            init(data) {
                ['icon', 'message', 'title'].forEach(element => {
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