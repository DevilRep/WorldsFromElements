<template>
    <nav class="navbar navbar-expand-lg navbar-light bg-ligth">
        <router-link to="/" class="navbar-brand">WorldFromElements</router-link>
        <button class="navbar-toggler"
                type="button"
                data-toggle="collapse"
                data-target="#menu"
                aria-controls="menu"
                aria-expanded="false"
                aria-label="Toogle navigation"
        >
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="menu">
            <ul class="navbar-nav mr-auto">
                <li v-if="newGameAvailable" class="nav-item active">
                    <a href="#" class="nav-link" v-on:click="newGame">New game</a>
                </li>
            </ul>
            <ul v-if="user" class="navbar-nav">
                <li class="nav-item">{{ this.user.name }}</li>
            </ul>
        </div>
    </nav>
</template>

<script>
    import EventBus from '../eventBus';

    export default {
        data: () => ({
            newGameAvailable: false,
            user: null
        }),
        mounted() {
            EventBus.$on('game:new:on', this.enableNewGame);
            EventBus.$on('game:new:off', this.disableNewGame);
            EventBus.$on('user:info', this.loadUserInfo);
        },
        methods: {
            newGame() {
                EventBus.$emit('game:new');
            },
            enableNewGame() {
                if (this.newGameAvailable) {
                    return;
                }
                this.newGameAvailable = true;
            },
            disableNewGame() {
                if (!this.newGameAvailable) {
                    return;
                }
                this.newGameAvailable = false;
            },
            async loadUserInfo() {
                try {
                    let result = await window.axios.get('/api/user/info');
                    this.user = result.data;
                } catch (error) {
                    EventBus.$emit('modal:error:show', error.response.data.message);
                }
            }
        }
    }
</script>