<template>
  <template v-if="!hideDetails">
    <div class="text-slate-900/50 mb-3">{{ `showing ${item.count()} of ${item.total()} results` }}</div>
  </template>
  <template v-for="(item, i) in item.items" :key="i">
    <div class="p-5 mb-3 bg-blue-50">
      <slot name="item" v-bind="{ item, index: i }"></slot>
    </div>
  </template>
  <infinite-loading :key="`key-${item.params.q}`" :firstload="false" @infinite="onScrollReachedEnd"></infinite-loading>
</template>

<script setup>
import { reactive } from 'vue';
import { debounce } from 'lodash';
import { useEmitter } from '@/plugins/mitt';
import { defineItems } from '@/services/Items';
import queryString from 'query-string';

const { api } = defineProps({
  api: {
    type: Object,
    default: () => {},
  },
  hideDetails: {
    type: Boolean,
    default: false,
  },
});

const $params = reactive(queryString.parse(window.location.search));
const $emitter = useEmitter();

const item = reactive(defineItems());

async function init () {
  const { data } = await list();

  item.setItems(data.data);
  item.setPagination(data.meta);
  item.incrementPage();

  $emitter.on('enter:search', (query) => {
    search(query);
  });
}

async function search (query) {
  item.setSearch(query);
  const { data } = await list();

  item.setItems(data.data);
  item.setPagination(data.meta);
  console.log('Searched:');
  console.table({ ...item.pagination, lastPage: item.isLastPage() });
}

function list () {
  return window.axios.get(api.list, { params: item.params });
}

const onScrollReachedEnd = debounce(async function ($state) {
  try {
    const { data } = await list();

    if (item.isLastPage()) {
      $state.complete();
    } else {
      item.addItems(data.data);
      item.setPagination(data.meta);
      $state.loaded();
    }
    item.incrementPage();
    console.log('Scrolled');
    console.table({ ...item.pagination, lastPage: item.isLastPage() });
    console.log('Scrolled');
    console.log(item.params, data.meta);
  } catch (err) {
    $state.error();
    console.error(err);
  }
}, 500);

init();
</script>

