<template>
  <section class="section">
    <div class="container">
      <h1 class="title">{{title}}</h1>
      <hr />
      <slot></slot>
    </div>
  </section>
</template>

<script>
export default {
  props: ['title']
}
</script>
