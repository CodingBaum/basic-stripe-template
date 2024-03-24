<script lang="ts" setup>
import {addToCart} from "@/services/CartService";
import type Product from "@/models/Product";
import {ref} from "vue";

defineProps<{
  product: Product
}>();

const popupOpen = ref(false);
</script>

<template>
  <div class="product-container">
    <img :src="product.image" @click="popupOpen=!popupOpen"/>
    <div class="info-section">
      <div class="title" :title="product.name"  @click="popupOpen=!popupOpen">{{ product.name }}</div>
      <div class="price">{{ product.price }} {{ product.currency_code == "eur" ? "€" : "$" }}</div>
      <div class="button-container">
        <button @click="addToCart(product)">Add to cart</button>
        <div class="button-line"/>
      </div>
    </div>
  </div>
  <div v-show="popupOpen"
       :class="{'product-popup-wrapper':true, 'popup-open':popupOpen, 'popup-closed':!popupOpen}"
       @click="popupOpen=false">
    <div class="prodcut-popup">

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

.title:hover, img:hover{
  cursor: pointer;
}

.product-popup-wrapper{
  position: fixed;
  width: 100%;
  height: 100%;
  top: 0;
  left: 0;

  animation-duration: 1.25s;
  animation-timing-function: ease-out;
}

.popup-closed {
  background: rgba(0, 0, 0, 0);
  z-index: -1;
  animation-name: fade-out;

}

.popup-open {
  background: rgba(0, 0, 0, 0.3);
  animation-name: fade-in;
}

@keyframes fade-in {
  from {
    background: rgba(0, 0, 0, 0);
  }

  to {
    background: rgba(0, 0, 0, 0.3);
  }
}

@keyframes fade-out {
  from {
    background: rgba(0, 0, 0, 0.3);
    z-index: 2;
  }

  to {
    background: rgba(0, 0, 0, 0);
    z-index: -1;
  }
}
</style>