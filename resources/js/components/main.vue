<template>
    <div class="container">
        <router-view></router-view>
        <modal-component ref="modal"></modal-component>
    </div>
</template>

<script>
    import { EventBus } from '../eventBus';

    export default {
        data: () => ({

        }),
        mounted() {
            EventBus.$on('modal:error:show', this.showError);
            EventBus.$on('modal:message:show', this.showMessage);
            EventBus.$on('token:update', this.tokenUpdate);
        },
        methods: {
            showError(error) {
                this.showMessage({
                    type: 'error',
                    title: 'Error!',
                    message: error.message
                });
            },
            showMessage(data) {
                this.$refs.modal
                    .init(data)
                    .open()
            },
            tokenUpdate(data) {
                debugger;
                if (!data.access_token) {
                    return;
                }

                window.axios.defaults.headers.common.Authorization = 'Bearer ' + data.access_token;
            }
        }
    }
</script>