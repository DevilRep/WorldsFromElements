import EventBus from '../eventBus';

export default {
    methods: {
        errorHandler(error) {
            if (error.response.status === 401) {
                EventBus.$emit('user:clear');
                return this.$router.push({ name: 'login' });
            }
            EventBus.$emit('modal:error:show', error.response.data.message);
        }
    }
}