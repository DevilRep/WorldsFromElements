<template>
    <div class="loader" v-show="isVisible" :class="classes">
        Loading...
    </div>
</template>

<script>
    export default {
        data: () => ({ isVisible: true }),
        computed: {
            classes() {
                return {
                    'is-visible': this.isVisible
                };
            }
        },
        methods: {
            show() {
                this.isVisible = true;
            },
            hide() {
                this.isVisible = false;
            }
        }
    };
</script>