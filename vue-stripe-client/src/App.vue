<script setup lang="ts">
</script>

<script lang="ts">
export default {
    data() {
        return {
            products: []
        }
    },
    methods: {
        async checkout() {
            await fetch("http://localhost:8000/api/checkout", {
                method: "POST"
            }).then(data => data.json()).then(data => {
                window.location.href = data.url;
            })
        }
    },
    mounted() {
        fetch("http://localhost:8000/api/products")
            .then(data => data.json())
            .then(data => {
                console.log(data)
                this.products = data
            })
    }
}
</script>

<template>
    <div id="product-wrapper">
        <div v-for="product in products">
            <div class="name">{{product.name}}</div>
            <div class="description">{{product.description}}</div>
            <img :src="product.image">
            <div class="price">{{product.price}}</div>
            <input type="checkbox">
        </div>
    </div>
    <button @click="checkout">checkout</button>
</template>

<style scoped>
header {
    line-height: 1.5;
    max-height: 100vh;
}

.logo {
    display: block;
    margin: 0 auto 2rem;
}

nav {
    width: 100%;
    font-size: 12px;
    text-align: center;
    margin-top: 2rem;
}

nav button a.router-link-exact-active {
    color: var(--color-text);
}

nav button a.router-link-exact-active:hover {
    background-color: transparent;
}

nav button a {
    display: inline-block;
    padding: 0 1rem;
    border-left: 1px solid var(--color-border);
}

nav a:first-of-type {
    border: 0;
}

@media (min-width: 1024px) {
    header {
        display: flex;
        place-items: center;
        padding-right: calc(var(--section-gap) / 2);
    }

    .logo {
        margin: 0 2rem 0 0;
    }

    header .wrapper {
        display: flex;
        place-items: flex-start;
        flex-wrap: wrap;
    }

    nav {
        text-align: left;
        margin-left: -1rem;
        font-size: 1rem;

        padding: 1rem 0;
        margin-top: 1rem;
    }
}
</style>
