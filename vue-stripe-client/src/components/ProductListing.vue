<script lang="ts" setup>
import {fetchProducts, products} from "@/services/CartService";
import Product from "@/components/Product.vue";
import {onMounted} from "vue";

onMounted(() => {
  fetchProducts();
})
</script>

<template>
  <br>
  <br>
  <br>
  <div class="listing-container">
    <Product v-for="(product, index) in products"
             :key="index"
             :product="product"/>
  </div>
</template>

<style scoped>
.listing-container{
  display: flex;
  flex-direction: row;
  justify-content: center;
  flex-wrap: wrap;
  gap: 40px;

  padding: 20px;
  width: 100%;
}

@media screen and (min-width: 1000px) {
  .listing-container {
    width: 1040px;
    margin: 20px auto 20px auto;
  }
}
</style>