<template>
    <div class="progress-bar">
        <span class="value" v-bind:style="styles"></span>
        <span class="title">{{ current }} / {{ max }}</span>
    </div>
</template>

<script>
    export default {
        props: ['min', 'max'],
        data: () => ({
            current: 0
        }),
        mounted() {
            if (this.current < this.min) {
                this.start();
            }
            if (this.current > this.max) {
                this.end();
            }
        },
        computed: {
            styles() {
                return {
                    width: Math.round(this.current / this.max * 100) + '%'
                };
            }
        },
        methods: {
            start() {
                this.current = this.min;
            },
            set(value) {
                this.current = value;
            },
            increment(value = 1) {
                this.current += value;
            },
            end() {
                this.current = this.max;
            }
        }
    }
</script>