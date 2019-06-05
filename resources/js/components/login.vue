<template>
    <div class="page login">
        <div class="row">
            <div class="card col-6 mx-auto">
                <div class="card-body">
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
                        <div class="mx-auto">
                            <button class="btn btn-primary" v-on:click="login">Log in</button>
                            <button class="btn btn-primary" v-on:click="signup">Sign up now!</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import EventBus from '../eventBus';
    import Login from '../mixins/login';
    import ErrorHandler from '../mixins/error';

    export default {
        mixins: [Login, ErrorHandler],
        methods: {
            async login() {
                if (
                    !this.isEmailValid() ||
                    !this.isPasswordValid() ||
                    !this.isPasswordLongEnough()
                ) {
                    return;
                }
                try {
                    let result = await window.axios.post('/api/user/login', {
                        email: this.email,
                        password: this.password
                    });
                    EventBus.$emit('token:update', result.data);
                    this.$router.push({name: 'home'});
                } catch (error) {
                    this.errorHandler(error);
                }
            },
            signup() {
                this.$router.push({ name: 'signup' });
            }
        }
    }
</script>