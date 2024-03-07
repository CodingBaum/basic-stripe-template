<script lang="ts" setup>
import {onMounted, ref} from "vue";
import type {Ref} from "vue";
import Product from "@/models/Product";

const cart: Ref<Product[]> = ref([]);

function getItem<T>(key: string): T | null {
    const item = localStorage.getItem(key);
    return item ? JSON.parse(item) as T : null;
}

onMounted(() => {
    let cartFromLocalStorage: Product[] | null = getItem("cart");

    if (cartFromLocalStorage != null) {
        cart.value = cartFromLocalStorage;
    }
});

</script>

<template>
    <div class="car-sidebar-wrapper">
        <div v-for="(product, index) in cart" :key="index">
            {{ product.name }}
            {{ product.quantity }}
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