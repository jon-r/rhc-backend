<template>
  <nav class="navbar is-fixed-top is-primary">
    <div class="navbar-brand">
      <router-link to="/" class="navbar-item" active-class="is-active" >
        RHC logo
      </router-link>

      <button
      class="button navbar-burger"
      :class="{'is-active': menuOpen}"
      @click="toggleMenu"
      >
        <span></span>
        <span></span>
        <span></span>
      </button>
    </div>

    <div class="navbar-menu" :class="{'is-active': menuOpen}">
      <div class="navbar-start">
        <router-link to="/site" class="navbar-item" active-class="is-active" >Site</router-link>
        <router-link to="/bar" class="navbar-item" active-class="is-active" >Go to Bar</router-link>
      </div>

      <div class="navbar-end" >
        (login details to go here)
      </div>

    </div>
  </nav>
</template>

<script>

export default {

  data() {
    return {
      greeting: 'hello world',
      menuOpen: false
    }
  },

  methods: {
    toggleMenu() {
      this.menuOpen = !this.menuOpen;
    }
  }
}
</script>
