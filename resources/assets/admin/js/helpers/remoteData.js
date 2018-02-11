import axios from 'axios';

const API_ROOT = 'api/v1';//process.env;

export function fetchFromAPI(endpoint, params) {
  // security+caching to go here
  return axios.get(API_ROOT + endpoint);
}
