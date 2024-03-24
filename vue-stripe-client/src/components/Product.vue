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
      <div class="title" :title="product.name" @click="popupOpen=!popupOpen">{{ product.name }}</div>
      <div class="price">{{ product.price }} {{ product.currency_code == "eur" ? "€" : "$" }}</div>
      <div class="button-container">
        <button @click="addToCart(product)">Add to cart</button>
        <div class="button-line"/>
      </div>
    </div>
  </div>
  <div :class="{'product-popup-wrapper':true, 'popup-open':popupOpen, 'popup-closed':!popupOpen}">
    <div class="product-popup">
      <nav class="close-nav">
        <div class="close-button">
          <button @click="popupOpen = false">CLOSE</button>
          <div class="button-line"/>
        </div>
      </nav>
      <div class="content-wrapper">
        <img :src="product.image" alt="product image" class="detail-image">
        <div class="info-wrapper">
          <div :title="product.name" class="title">{{ product.name }}</div>
          <div class="description">{{ product.description }}</div>
          <div class="action-container">
            <div class="price"><span class="price-label">Price per Unit: </span>{{ product.price }} {{ product.currency_code == "eur" ? "€" : "$" }}
            </div>
            <div class="button-container">
              <button @click="()=>{addToCart(product);popupOpen = false}">Add to cart</button>
              <div class="button-line"/>
            </div>
          </div>
        </div>
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

.title:hover, img:hover {
  cursor: pointer;
}

/* Detail-PopUp */

.product-popup-wrapper {
  position: fixed;
  height: 100%;
  width: 100%;
  right: 0;
  top: 0;
  display: flex;

  animation-duration: 0.25s;
  animation-timing-function: ease-out;

  display: flex;
  justify-content: center;
  align-items: center;

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

.product-popup {
  max-height: 500px;
  width: clamp(200px, 80vw, 800px);
  background-color: white;
  border-radius: 5px;
  padding: 25px;
}

.close-nav {
  display: flex;
  justify-content: flex-end;
  margin-bottom: 20px;
}

.close-button > button {
  background: none;
  border: none;
}

.button-line {
  height: 1px;
  width: 0;
  background-color: black;
}

.close-button:hover {
  cursor: pointer;

  * {
    cursor: pointer;
  }

  .button-line {
    width: 100%;
    animation-name: underline;
    animation-duration: 0.25s;
    animation-timing-function: ease-out;
  }
}

.content-wrapper {
  display: flex;
  flex-direction: row;
  gap: 30px;

}

.detail-image {
  margin: auto 0 auto 0;
}

.info-wrapper {
  flex-grow: 1;
  display: flex;
  flex-direction: column;
  justify-content: space-between;
  gap: 20px;

  max-height: 400px;

  .title {
    width: fit-content;

    &:hover {
      cursor: initial;
    }
  }

  .description {
    overflow-y: auto;
  }
}

.action-container {
  display: flex;
  flex-direction: row;
  justify-content: space-between;
}

@media screen and (max-width: 650px) {
  .content-wrapper {
    flex-direction: column;
    align-items: center;
  }

  .product-popup{
    max-height: fit-content;

    .price-label{
      display: none;
    }
  }
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