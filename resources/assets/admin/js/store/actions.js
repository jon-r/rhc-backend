import {fetchFromAPI} from '../helpers/remoteData';

import {GET_MENUS} from './mutations';

export default {
  async getMenus({ commit }) {
    let {data} = await fetchFromAPI('/layout/init');
    commit(GET_MENUS, data);
  }
}
