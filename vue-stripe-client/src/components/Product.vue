<script lang="ts" setup>
import {addToCart} from "@/services/CartService";
import type Product from "@/models/Product";

defineProps<{
  product: Product
}>();
</script>

<template>
  <div class="product-container">
    <img :src="product.image"/>
    <div class="info-section">
      <div class="title" :title="product.name">{{ product.name }}</div>
      <div class="price">{{ product.price }} {{ product.currency_code == "eur" ? "€" : "$" }}</div>
      <div class="button-container">
        <button @click="addToCart(product)">Add to cart</button>
        <div class="button-line"/>
      </div>
    </div>
  </div>
</template>

<style scoped>
.product-container {
  display: flex;
  flex-direction: column;
  gap: 5px;
  border-radius: 5px;
  padding: 10px;
}

.info-section {
  display: flex;
  flex-direction: column;
  gap: 10px;
  height: 100%;
  justify-content: space-between;
}

.button-container {
  width: fit-content;
}

button {
  font-weight: bolder;
}

.button-line {
  height: 1px;
  width: 0;
  background-color: black;
}

.button-container:hover {
  cursor: pointer;

  .button-line {
    width: 100%;
    animation-name: underline;
    animation-duration: 0.25s;
    animation-timing-function: ease-out;
  }
}

@keyframes underline {
  0% {
    width: 0;
  }

  100% {
    width: 100%;
  }
}

.title {
  font-size: 16px;
  color: #302B27;
  font-weight: bold;

  width: 200px;
  white-space: nowrap;
  overflow: hidden;
  text-overflow: ellipsis;
}

img {
  aspect-ratio: 1;
  object-fit: cover;
  width: 200px;
  height: 200px;
  border-radius: 5px;
}

button {
  border: none;
  background-color: transparent;
  border-radius: 5px;
  width: fit-content;
  text-align: left;
  padding: 0;
}

button:hover {
  cursor: pointer;
}
</style>