import './bootstrap';
import { createApp } from 'vue/dist/vue.esm-bundler.js';
import AppListItems from './components/List/AppListItems.vue';
import AppSearchField from './components/Search/AppSearchField.vue';
import infiniteLoading from './plugins/infinite-loading';
import mitt from './plugins/mitt';

const app = createApp({
  components: {
    AppListItems,
    AppSearchField,
  },
});

app.use(mitt);

app.use(infiniteLoading);

app.mount('#app');
