<script setup lang="ts">
import {addToCart, fetchProducts, products} from "@/services/CartService";
import {onMounted} from "vue";

onMounted(() => {
    fetchProducts();
})
</script>

<template>
    <main>
        <div v-for="(product, index) in products" :key="index">
            {{ product.name }}
            <button @click="addToCart(product)">Add to cart</button>
        </div>
    </main>
</template>
