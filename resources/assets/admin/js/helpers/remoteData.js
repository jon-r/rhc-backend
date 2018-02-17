import axios from 'axios';

import { API_ROOT } from './config';

export function fetchFromAPI(endpoint) {
  // security+caching to go here
  return axios.get(API_ROOT + endpoint);
}

export function doSomethingElse() {
  return true;
}
