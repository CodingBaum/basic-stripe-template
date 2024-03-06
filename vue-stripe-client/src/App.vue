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
                method: "POST",
                body: JSON.stringify([
                    {
                        "prod_id": "prod_PgcgAdQasdMEr9",
                        "name": "Online e-commerce course",
                        "description": "An entry level e-commerce to take you back to the basics. Like a legend once said: \"Mak erscht ma die basics\"",
                        "image": "https:\/\/files.stripe.com\/links\/MDB8YWNjdF8xT2xSTGNEbm9QNTBlaWZDfGZsX3Rlc3RfRXRWTHlXZnlCU01tME44WjR0aHRMeXVx00uFLuGwzz",
                        "price": 199.99,
                        "currency_code": "eur"
                    },
                    {
                        "prod_id": "prod_Pgcbw18hsXRr4g",
                        "name": "WLAN Kabel",
                        "description": "Kabel für High Speed WLAN",
                        "image": "https:\/\/files.stripe.com\/links\/MDB8YWNjdF8xT2xSTGNEbm9QNTBlaWZDfGZsX3Rlc3RfU3JlbVE1VUxUZ0Yxdm5EU3FVWUFZNjh500ngG9BzCC",
                        "price": 20,
                        "currency_code": "eur"
                    },
                    {
                        "prod_id": "prod_Pgc6u8JXkTgjeD",
                        "name": "1000 V-BUCKS FREE",
                        "description": "GET 1000 V-BUCKS FOR FREE",
                        "image": "https:\/\/files.stripe.com\/links\/MDB8YWNjdF8xT2xSTGNEbm9QNTBlaWZDfGZsX3Rlc3RfNk9kQXNRVWUyTDZiczRQU0NzRkRjYzly0076jMEQ2a",
                        "price": 99.99,
                        "currency_code": "eur"
                    }
                ])
            }).then(data => data.json()).then(data => {
                window.location.href = data.url;
            })
        }
    },
    mounted() {
        fetch("http://localhost:8000/api/products")
            .then(data => data.json())
            .then(data => {
                this.products = data
            })
    }
}
</script>

<template>
    <div id="wrapper">
        <div id="product-wrapper">
            <div class="product" v-for="product in products">
                <div class="name">{{product.name}}</div>
                <div class="description">{{product.description}}</div>
                <img class="image" :src="product.image">
                <div class="price">{{product.price}} {{product.currency_code === "eur" ? "€" : "$"}}</div>
                <input type="checkbox">
            </div>
        </div>
        <button @click="checkout">checkout</button>
    </div>
</template>

<style scoped>
#wrapper {
    display: flex;
    flex-direction: column;
}

#product-wrapper {
    display: flex;
    flex-direction: row;
}

.product {
    margin: 1rem;
    display: flex;
    flex-direction: column;
    justify-content: space-between;
}

.name {
    font-size: large;
    font-weight: bold;
}

.image {
    max-width: 200px;
}

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
