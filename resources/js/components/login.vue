<template>
    <div class="page login">
        <div class="row">
            <div class="card col-6 mx-auto">
                <div class="card-body">
                    <div class="row username-wrapper">
                        <label class="label" for="username">Username</label>
                        <input type="text" class="username form-control" id="username" v-model="username">
                    </div>
                    <div class="row password-wrapper">
                        <label class="label" for="password">Password</label>
                        <input type="text" class="password form-control" id="password" v-model="password">
                    </div>
                    <div class="row text-right">
                        <button v-on:click="login">Log in</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import { EventBus } from '../eventBus';

    export default {
        data: () => ({ username: '', password: ''}),
        methods: {
            login() {
                window.axios.post('/api/login', {
                        username: this.username,
                        password: this.password
                    })
                    .then(result => {
                        console.log(result);
                    })
                    .catch(error => {
                        EventBus.$emit('modal:error:show', error.response.data)
                    });
            }
        }
    }
</script>