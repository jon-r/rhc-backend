import { fetchFromAPI } from '../helpers/remoteData';

import { GET_MENUS } from './mutations';

export default {
  async getMenus({ commit }) {
    const { data } = await fetchFromAPI('/admin/app-layout');
    commit(GET_MENUS, data);
  },
};
