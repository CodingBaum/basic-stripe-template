<script setup lang="ts">
import {removeAllFromCart} from "@/services/CartService";
import type Product from "@/models/Product";

defineProps<{
  product: Product
}>()
</script>

<template>
  <div class="cart-item-wrapper">
    <div class="hr"/>
    <div class="cart-item">
      <img :src="product.image" alt="product image"/>
      <div class="info-container">
        <div :title="product.name" class="title">{{ product.name }}</div>
        <div>
          {{ product.quantity }}
          <img class="multiply"
               src="@/assets/icons/remove.svg"
               alt="remove icon">
          {{ product.price }} {{ product.currency_code == "eur" ? "€" : "$" }}
        </div>
      </div>
      <img @click="removeAllFromCart(product)"
           class="remove-button"
           src="@/assets/icons/remove.svg"
           alt="remove icon">
    </div>
  </div>
</template>

<style scoped>

.cart-item-wrapper {
  display: flex;
  flex-direction: column;
  gap: 25px;
  margin-bottom: 25px;
}

.hr {
  height: 1px;
  background: #e2e8f0;
}

.cart-item {
  display: flex;
  flex-direction: row;
  gap: 15px;
  justify-content: space-between;
}

.info-container {
  display: flex;
  flex-direction: column;
  justify-content: space-between;
}

.title {
  width: 170px;
  white-space: nowrap;
  overflow: hidden;
  text-overflow: ellipsis;
  font-weight: 600;
}

img {
  height: 60px;
  aspect-ratio: 1;
  object-fit: cover;
  border-radius: 4px;
}

.multiply {
  height: 12px;
  width: 12px;
  padding-top: 2px;
}

.remove-button {
  width: 25px;
  height: 25px;
  margin: auto 0 auto 0;
  border: none;
  background-color: transparent;

  &&:hover {
    cursor: pointer;
    font-weight: bold;
  }
}

</style>