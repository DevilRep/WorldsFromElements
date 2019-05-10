<template>
    <div class="progress-bar">
        <span class="value"></span>
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