<script lang="ts" setup>
import {addToCart, cart, getCart, removeFromCart} from "@/services/CartService";
import {onMounted} from "vue";

onMounted(() => {
    getCart();
})
</script>

<template>
    <div class="car-sidebar-wrapper">
        <div v-for="(product, index) in cart" :key="index">
            {{ product.name }}
            {{ product.quantity }}
            <button @click="addToCart(product)">+</button>
            <button @click="removeFromCart(product)">-</button>
        </div>
    </div>
</template>

<style scoped>
.car-sidebar-wrapper {
    position: fixed;
    height: 100vh;
    width: 100px;
    background: rebeccapurple;
    right: 0;
}
</style>