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
    <div class="cart-sidebar-wrapper">
        <div class="cart-sidebar-container">
            <nav class="close-nav">
                <button class="close-button">CLOSE</button>
            </nav>
            <div class="product-container">
                <div class="cart-item" v-for="(product, index) in cart" :key="index">
                    <div class="hr"></div>
                    <div class="product-details">
                        <div class="product-name-quantity">
                            <img src="https://placehold.co/75x75">
                            {{ product.name }}
                            {{ product.quantity }}
                            <button @click="addToCart(product)">+</button>
                            <button @click="removeFromCart(product)">-</button>
                        </div>
                    </div>
                </div>
            </div>
            <div>
                <p>Subtotal</p>
                <p>€2600</p>
            </div>
            <button v-if="cart.length" @click="checkout">Checkout</button>
        </div>
    </div>
</template>

<style scoped>
.cart-sidebar-wrapper {
    position: fixed;
    height: 100vh;
    width: 100%;
    right: 0;
    background: rgba(0, 0, 0, 0.3);
    display: flex;
    justify-content: flex-end;
}

.cart-sidebar-container {
    width: 350px;
    background: white;
    padding: 10px 25px;
}

.close-nav {
    display: flex;
    justify-content: flex-end;
    margin-bottom: 20px;
}

.close-nav .close-button {
    background: none;
    border: none;
}

.product-container {

}

.cart-item {
    display: flex;
    flex-direction: column;
    gap: 10px;
    margin-bottom: 10px;
}

.cart-item .hr {
    height: 1px;
    background: #e2e8f0;
}

.cart-item .product-details {
    display: flex;
    flex-direction: row;
    gap: 5px;
}

.product-name-quantity {

}
</style>