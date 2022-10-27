<template>
  <div class="mb-4">
    <input
      :value="search"
      v-bind="$attrs"
      class="text-2xl shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
      type="search"
      @search="onSearchEnter"
      @keyup="onKeyup"
    >
  </div>
</template>

<script setup>
import { reactive } from 'vue';
import { useEmitter } from '@/plugins/mitt';
import queryString from 'query-string';

const $emitter = useEmitter();
const $params = reactive(queryString.parse(window.location.search));
const search = $params.q;

function onKeyup (e) {
  $emitter.emit('enter:keyup', e.target.value);
}

function onSearchEnter (e) {
  $emitter.emit('enter:search', e.target.value);
}
</script>
