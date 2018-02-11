<template>

</template>
<script>
export default {
  data() {
    return {
      menus: [
        {
          name: 'Top Right',
          location: 'navbar/right-menu'
        }
      ]
    }
  },

  created() {
    this.$store.dispatch('getMenus');
  }
}
</script>
