import Vuex from 'vuex'
import Vue from 'vue'
import zoneui from './zoneui';

Vue.use(Vuex);

export default new Vuex.Store({
  modules: {
    zoneui
  }
})
