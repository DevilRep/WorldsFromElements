<template>
    <div class="container">
        <router-view></router-view>
        <vue-modal ref="modalSuccess"></vue-modal>
        <vue-modal ref="modalError"></vue-modal>
        <vue-loader ref="loader"></vue-loader>
    </div>
</template>

<script>
    import EventBus from '../eventBus';
    import VueCookies from 'vue-cookies';

    export default {
        created() {
            EventBus.$on('modal:error:show', this.errorHandler);
            EventBus.$on('modal:message:show', this.showMessage);
            EventBus.$on('token:update', this.tokenUpdate);
            EventBus.$on('token:clear', this.tokenClear);
            EventBus.$on('loader:show', () => this.$refs.loader.show());
            EventBus.$on('loader:hide', () => this.$refs.loader.hide());
        },
        mounted() {
            EventBus.$once('router:loaded', () => EventBus.$emit('loader:hide'));
            EventBus.$emit('router:load:check');
        },
        methods: {
            errorHandler(error) {
                this.$refs.modalError
                    .init({
                        type: 'error',
                        title: 'Error!',
                        message: error
                    })
                    .open();
            },
            showMessage(data) {
                this.$refs.modalSuccess
                    .init(data)
                    .open();
            },
            tokenUpdate(data) {
                if (!data.access_token) {
                    return;
                }
                VueCookies.set('auth', data.access_token);
                window.axios.defaults.headers.common.Authorization = 'Bearer ' + data.access_token;
            },
            tokenClear() {
                delete window.axios.defaults.headers.common.Authorization;
            }
        }
    }
</script>