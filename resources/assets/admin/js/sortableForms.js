
const els = document.querySelectorAll('[data-sortable]');

console.log(els);

els.forEach(el => {
  console.log('sortable.');
  Sortable.create(el, {
    handle: '.drag-handle'
  })
});
