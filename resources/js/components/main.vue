<template>
    <div class="container">
        <router-view></router-view>
        <modal-component ref="modal"></modal-component>
        <loader-component ref="loader"></loader-component>
    </div>
</template>

<script>
    import EventBus from '../eventBus';

    export default {
        mounted() {
            EventBus.$on('modal:error:show', this.showError);
            EventBus.$on('modal:message:show', this.showMessage);
            EventBus.$on('token:update', this.tokenUpdate);
            EventBus.$on('loader:show', () => this.$refs.loader.show());
            EventBus.$on('loader:hide', () => this.$refs.loader.hide());
            EventBus.$once('router:loaded', () => EventBus.$emit('loader:hide'));
            EventBus.$emit('router:load:check');
        },
        methods: {
            showError(error) {
                this.showMessage({
                    type: 'error',
                    title: 'Error!',
                    message: error
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