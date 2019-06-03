<template>
    <div class="page signup">
        <div class="row">
            <div class="card col-6 mx-auto">
                <div class="card-body">
                    <div class="row name-wrapper">
                        <label class="label" for="name">Name</label>
                        <input type="text" class="email form-control mb-2" id="name" v-model="name">
                    </div>
                    <div class="row email-wrapper">
                        <label class="label" for="email">Email</label>
                        <input type="text" class="email form-control mb-2" id="email" v-model="email">
                    </div>
                    <div class="row password-wrapper">
                        <label class="label" for="password">Password</label>
                        <div class="input-group mb-2">
                            <input v-bind:type="passwordFieldType" class="password form-control" id="password" v-model="password">
                            <div class="input-group-append">
                                <div class="input-group-text" v-on:click="togglePassword">
                                    <i class="fa" :class="passwordIconClasses" aria-hidden="true"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row controls-wrapper">
                        <button class="btn btn-primary mx-auto" v-on:click="signup">Sign up</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import EventBus from '../eventBus';
    import Login from '../mixins/login';

    export default {
        mixins: [Login],
        data: () => ({
            name: ''
        }),
        methods: {
            signup() {
                if (
                    !this.isEmailValid() ||
                    !this.isPasswordValid() ||
                    !this.isPasswordLongEnough()
                ) {
                    return;
                }
                window.axios.post('/api/signup', {
                    name: this.name,
                    email: this.email,
                    password: this.password
                })
                    .then(result => {
                        EventBus.$emit('modal:message:show', {
                            type: 'success',
                            title: 'Welcome!',
                            message: 'You are singed in'
                        });
                        EventBus.$emit('token:update', result.data);
                        this.$router.push({ name: 'home' });
                    })
                    .catch(error => EventBus.$emit('modal:error:show', error.response.data.message));
            }
        }
    }
</script>