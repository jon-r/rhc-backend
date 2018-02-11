<template>
  <section class="hero">
    <div class="hero-body">
      <div class="container">
        <h1 class="title">
          {{ greeting }}
        </h1>
        <h2 class="subtitle">
          Hero subtitle
        </h2>
      </div>
    </div>

    <b-dropdown>
      <button class="button is-primary" slot="trigger">
          <span>Click me!</span>
          <b-icon icon="menu-down"></b-icon>
      </button>

      <b-dropdown-item>Action</b-dropdown-item>
      <b-dropdown-item>Another action</b-dropdown-item>
      <b-dropdown-item>Something else</b-dropdown-item>
    </b-dropdown>
  </section>
</template>

<script>
export default {
  data() {
    return {
      greeting: 'hello world'
    }
  }
}
</script>
