<script setup lang="ts">
import {onMounted, ref} from "vue";

class Product {
    prod_id: string;
    name: string;
    description: string;
    image: string;
    price: number;
    currency_code: string;
    quantity: number

    constructor(prod_id: string, name: string, description: string, image: string, price: number, currency_code: string, quantity: number) {
        this.prod_id = prod_id;
        this.name = name;
        this.description = description;
        this.image = image;
        this.price = price;
        this.currency_code = currency_code;
        this.quantity = quantity;
    }
}

const products = ref([]);
const cart = ref([]);

onMounted(() => {
    fetch("http://localhost:8000/api/products")
        .then(data => data.json())
        .then(data => {
            products.value = data
        });
});

function setItem<T>(key: string, value: T): void {
    localStorage.setItem(key, JSON.stringify(value));
}

function getItem<T>(key: string): T | null {
    const item = localStorage.getItem(key);
    return item ? JSON.parse(item) as T : null;
}

function addToCart(product: Product) {
    let cartFromLocalStorage: Product[] | null = getItem("cart");

    if (cartFromLocalStorage != null) {
        cart.value = cartFromLocalStorage;
    }

    if (cart.value.some((cartItem: Product) => cartItem.prod_id === product.prod_id)) {
        cart.value.map((cartItem: Product) => {
            if (cartItem.prod_id === product.prod_id) {
                cartItem.quantity++;
            }

            return cartItem;
        });
    } else {
        cart.value.push(new Product(
            product.prod_id,
            product.name,
            product.description,
            product.image,
            product.price,
            product.currency_code,
            1
        ));
    }

    setItem("cart", cart.value);
}
</script>

<template>
    <main>
        <div v-for="(product, index) in products" :key="index">
            {{ product.name }}
            <button @click="addToCart(product)">Add to cart</button>
        </div>
    </main>
</template>
