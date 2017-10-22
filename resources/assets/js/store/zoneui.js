import _ from 'lodash';
import { getCurrentSlot } from '../timeutils';

const state = {
  // Example:
  highlightedCell: 0,
  highlightActive: false
};

const highlightFunc = _.debounce((commit) => {
commit('reset_highlight')
}, 2000);

const actions = {
  // Example:
  setHighlightedCell({commit}, value) {
    commit('set_hl_cell', value);
  },
  resetHighlight ({commit}, userTz) {
    highlightFunc(commit, userTz);
  },
  resetCell({commit}, userTz) {
    commit('set_hl_cell', userTz);
  },

};

const mutations = {
  // Example:
  set_hl_cell(state, value) {
    state.highlightedCell = value;
    state.highlightActive = true;
  },
  reset_highlight(state, userTz) {
    state.highlightActive = false;
    state.highlightedCell = getCurrentSlot(userTz);
  },
  reset_cell (state, userTz) {
    state.highlightedCell = getCurrentSlot(userTz);
  }
};

export default {
  state,
  actions,
  mutations
};
