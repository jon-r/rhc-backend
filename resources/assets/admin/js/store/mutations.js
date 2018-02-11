import state from './state';

export const GET_MENUS = 'LAYOUT/GET_MENUS';

export default {
  [GET_MENUS] (state, {menus}) {
    state.layout = {
      ...state.layout,
      menus
    }
  }
}
