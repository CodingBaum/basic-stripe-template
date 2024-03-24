<script lang="ts" setup>
import {cart, cartOpen, getCart} from "@/services/CartService";
import {computed, onMounted} from "vue";
import CartProduct from "@/components/CartProduct.vue";
import type Product from "@/models/Product";

onMounted(() => {
  getCart();
})

const itemCount = computed(() => {
  let count = 0;
  const products: Product[] = cart.value;

  if (products.length == 0) return null;

  for (const product of products) {
    count += product.quantity;
  }

  if (count > 99) return "99+";
  return count;
})

const subtotal = computed(() => {
  let total = 0;
  const products: Product[] = cart.value;

  if (products.length == 0) return 0;

  for (const product of products) {
    total += product.quantity * product.price;
  }

  return total.toFixed(2);
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
  <div @click="cartOpen = true" class="cart-icon-container">
    <img src="@/assets/icons/cart.svg" alt="cart icon">
    <div v-show="itemCount" class="item-count">{{ itemCount }}</div>
  </div>
  <div :class="{ 'cart-sidebar-wrapper': true, 'wrapper-open': cartOpen, 'wrapper-closed': !cartOpen }">
    <div :class="{ 'cart-sidebar-container': true, 'container-open': cartOpen, 'container-closed': !cartOpen }">
      <nav class="close-nav">
        <div class="close-button">
          <button @click="cartOpen = !cartOpen">CLOSE</button>
          <div class="button-line"/>
        </div>
      </nav>
      <div class="product-wrapper">
        <CartProduct v-for="(product, index) in cart" :key="index" :product="product"/>
        <div v-show="!cart.length" class="empty-cart">
          The Cart is currently empty.
        </div>
      </div>
      <div class="checkout-wrapper">
        <div class="subtotal">
          <div>Subtotal:</div>
          <div>{{ subtotal }} {{ cart.length == 0 ? "" : cart[0].currency_code == "eur" ? "€" : "$" }}</div>
        </div>
        <button v-if="cart.length" @click="checkout" class="checkout">CHECKOUT</button>
      </div>
    </div>
  </div>
</template>

<style scoped>
.cart-icon-container {
  position: fixed;
  right: 0;
  top: 0;

  padding: 15px 35px;

  &&:hover {
    cursor: pointer;
  }

  .item-count {
    position: absolute;
    top: 5px;
    left: 55px;

    display: flex;
    justify-content: center;
    align-items: center;

    padding: 5px;
    height: 16px;

    font-size: 10px;

    border-radius: 10px;
    background-color: black;
    color: white;
  }
}

.cart-sidebar-wrapper {
  position: fixed;
  height: 100vh;
  width: 100%;
  right: 0;
  display: flex;
  justify-content: flex-end;

  animation-duration: 0.25s;
  animation-timing-function: ease-out;

}

.wrapper-closed {
  background: rgba(0, 0, 0, 0);
  z-index: -1;
  animation-name: fade-out;

}

.wrapper-open {
  background: rgba(0, 0, 0, 0.3);
  animation-name: fade-in;
}

.cart-sidebar-container {
  width: 350px;
  background: white;
  padding: 10px 25px;

  position: relative;

  animation-duration: 0.25s;
  animation-timing-function: ease-out;

  display: flex;
  flex-direction: column;
}

.container-closed {
  right: -350px;
  animation-name: slide-out;

}

.container-open {
  right: 0;
  animation-name: slide-in;
}

.product-wrapper {
  overflow-y: auto;
  flex-grow: 1;

  display: flex;
  flex-direction: column;
}

.empty-cart{
  text-align: center;
  flex-grow: 1;

  display: flex;
  justify-content: center;
  align-items: center;
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

.checkout-wrapper {
  padding-bottom: 25px;
  background-color: white;
  box-shadow: 0 -10px 10px 0 rgba(255, 255, 255, 1);
}

.subtotal {
  display: flex;
  flex-direction: row;
  justify-content: space-between;
  padding: 25px 0;

  border-top: solid 1px #e2e8f0;
  border-bottom: solid 1px #e2e8f0;

}

.checkout {
  width: 100%;
  background-color: black;
  color: white;
  height: 45px;
  border: none;
  box-sizing: border-box;

  &&:hover {
    cursor: pointer;
    background-color: transparent;
    border: solid black 2px;
    color: black;
    box-sizing: border-box;
    animation-name: checkout-hover;
    animation-duration: 0.25s;
    animation-timing-function: ease-out;
  }
}

/* Animations */

@keyframes slide-in {
  from {
    right: -350px;
  }
  to {
    right: 0;
  }
}

@keyframes slide-out {
  from {
    right: 0;
  }
  to {
    right: -350px;
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

@keyframes underline {
  0% {
    width: 0;
  }

  100% {
    width: 100%;
  }
}

@keyframes checkout-hover {
  from {
    background-color: black;
    border: none;
    color: white;
  }

  to {
    background-color: transparent;
    border: solid black 2px;
    color: black;
  }
}
</style>