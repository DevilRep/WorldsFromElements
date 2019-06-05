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
                <li v-if="isNewGameAvailable" class="nav-item active">
                    <a href="#" class="nav-link" v-on:click="newGame">New game</a>
                </li>
            </ul>
            <ul v-if="user" class="navbar-nav">
                <li class="nav-item"><span class="nav-link">{{ this.user.name }}</span></li>
                <li class="nav-item"><a href="#" class="nav-link" v-on:click="logout">Log out</a></li>
            </ul>
        </div>
    </nav>
</template>

<script>
    import EventBus from '../eventBus';
    import VueCookies from 'vue-cookies';

    export default {
        data: () => ({
            newGameAvailable: false,
            user: null
        }),
        computed: {
            isNewGameAvailable() {
                return this.user && this.newGameAvailable;
            }
        },
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
            },
            async logout() {
                await window.axios.post('/api/user/logout');
                this.user = null;
                VueCookies.remove('auth');
                EventBus.$emit('token:clear');
                this.$router.push({ name: 'login' });
            }
        }
    }
</script>