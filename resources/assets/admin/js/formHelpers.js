document.querySelectorAll('[data-sortable]')
.forEach(el => {
  Sortable.create(el, {
    handle: '.drag-handle'
  })
});
