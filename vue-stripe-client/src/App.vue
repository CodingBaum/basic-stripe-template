<script lang="ts" setup>
import {onMounted, ref} from "vue";
import CartSidebar from "@/components/CartSidebar.vue";

const products = ref([])

onMounted(() => {
    fetch("http://localhost:8000/api/products")
        .then(data => data.json())
        .then(data => {
            products.value = data
            console.log(products.value)
        });
});

async function checkout() {
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
    });
}
</script>

<template>
    <main>
        <CartSidebar/>
        <RouterView/>
    </main>
</template>

<style scoped></style>
