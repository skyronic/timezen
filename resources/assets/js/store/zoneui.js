
const state = {
  // Example:
  highlightedCell: 0
};

const actions = {
  // Example:
  setHighlightedCell({commit}, value) {
    commit ('set_hl_cell', value);
  }
};

const mutations = {
  // Example:
  set_hl_cell(state, value) {
    state.highlightedCell = value;
  }
};

export default {
  state,
  actions,
  mutations
};
