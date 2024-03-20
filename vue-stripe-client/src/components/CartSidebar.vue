<script lang="ts" setup>
import {addToCart, cart, getCart, removeFromCart} from "@/services/CartService";
import {onMounted} from "vue";

onMounted(() => {
  getCart();
})

function checkout() {
  fetch("http://localhost:8000/api/checkout", {
    method: "POST",
    body: JSON.stringify(cart.value)
  }).then(data => data.json()).then(data => {
    window.location.href = data.url;
  })
}
</script>

<template>
  <div class="car-sidebar-wrapper">
    <div v-for="(product, index) in cart" :key="index" class="list-entry">
      {{ product.name }}
      {{ product.quantity }}
      <button @click="addToCart(product)">+</button>
      <button @click="removeFromCart(product)">-</button>
    </div>
    <button v-if="cart.length" @click="checkout">Checkout</button>
  </div>
</template>

<style scoped>
.car-sidebar-wrapper {
  position: fixed;
  height: 100vh;
  width: 200px;
  padding: 20px;
  background: #274690;
  right: 0;
}

.list-entry{
  display: flex;
  flex-direction: column;
}
</style>