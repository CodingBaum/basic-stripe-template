import {ref} from "vue";
import Product from "@/models/Product";
import type {Ref} from "vue";

export const cart: Ref<Product[]> = ref([]);
export const products: Ref<Product[]> = ref([]);
export function fetchProducts() {
    if (!products.value.length) {
        fetch("http://localhost:8000/api/products")
            .then(data => data.json())
            .then(data => {
                products.value = data
                console.log("data ", products.value)
            });
    }

    return products.value;
}

function setItem<T>(key: string, value: T): void {
    localStorage.setItem(key, JSON.stringify(value));
}

function getItem<T>(key: string): T | null {
    const item = localStorage.getItem(key);
    return item ? JSON.parse(item) as T : null;
}

export function getCart() {
    let cartFromLocalStorage: Product[] | null = getItem("cart");

    if (cartFromLocalStorage != null) {
        cart.value = cartFromLocalStorage;
    }
}

export function addToCart(product: Product) {
    getCart();

    if (cart.value.some((cartItem: Product) => cartItem.prod_id === product.prod_id)) {
        cart.value = cart.value.map((cartItem: Product) => {
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

export function removeFromCart(product: Product) {
    getCart();

    if (!cart.value.some((cartItem: Product) => cartItem.prod_id === product.prod_id)) {
        return;
    }

    cart.value = cart.value.map((cartItem: Product) => {
        if (cartItem.prod_id !== product.prod_id) {
            return cartItem;
        }

        cartItem.quantity--;

        return cartItem;
    });

    cart.value = cart.value.filter((cartItem: Product) => cartItem.quantity > 0);

    setItem("cart", cart.value);
}