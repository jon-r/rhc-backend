<template>
  <page-wrapper title="Site Options">
    <b-tabs type="is-toggle" expanded>
      <b-tab-item label="Pictures" icon="image">
        pics
      </b-tab-item>
      <b-tab-item label="Navigation Menus" >
        <nav-menus></nav-menus>
      </b-tab-item>
      <b-tab-item label="Videos" icon="video">
        vids
      </b-tab-item>
    </b-tabs>


  </page-wrapper>
</template>

<script>
import PageWrapper from '../PageWrapper.vue';
import NavMenus from './NavMenus.vue';

export default {
  components: {
    'page-wrapper': PageWrapper,
    'nav-menus': NavMenus
  }
}
</script>
