import mitt from 'mitt';
import { getCurrentInstance } from 'vue';

export function useEmitter () {
  const internalInstance = getCurrentInstance();
  return internalInstance?.appContext.config.globalProperties.$emit;
}

export default {
  install (Vue) {
    Vue.config.globalProperties.$emit = mitt();
  },
};
