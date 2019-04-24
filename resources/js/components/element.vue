<template>
    <div class="card element">
        <div class="card-body">
            <p class="card-text">{{ item.name }}</p>
        </div>
    </div>
</template>

<script>
    export default {
        props: ['item']
    }
</script>