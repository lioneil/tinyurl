<template>
  <header
    :class="{ 'shadow': navbar.isTopPage }"
    class="sticky top-0 p-2 w-full bg-white animated"
    v-bind="$attrs"
  >
    <slot></slot>
  </header>
</template>

<script setup>
import { onMounted, reactive } from 'vue';

const navbar = reactive({
  isTopPage: false,
});

onMounted(() => {
  window.addEventListener('scroll', onScroll);
});

function onScroll () {
  if (window.pageYOffset > 10) {
    navbar.isTopPage = true;
  } else {
    navbar.isTopPage = false;
  }
}
</script>

