<template>
  <h1> {{ title }}</h1>
  <div class="col-auto d-none d-lg-block">
    <svg class="bd-placeholder-img" width="200" height="250" xmlns="http://www.w3.org/2000/svg" preserveAspectRatio="xMidYMid slice" focusable="false" role="img" aria-label="Placeholder: Thumbnail">
      <title>{{ title }}</title>
      <rect width="100%" height="100%" fill="#55595c"/>
      <text x="50%" y="50%" fill="#eceeef" dy=".3em">image</text>
    </svg>
  </div>
  <div class="col p-4 d-flex flex-column position-static">
    <p class="mb-auto">{{ description }}</p>
    <h3 class="mb-1">{{ price }} euro</h3>
    <a :href="`${shop_url}`" class="btn btn-success mt-2" style="width: 200px">Add to cart</a>
  </div>

</template>

<script setup>
defineProps({
  title: String,
  description: String,
  price: String,
  id: String,
  shop_url: String
});
</script>
