(function($, d) {

// sortable elements
d.querySelectorAll('[data-sortable]')
.forEach(el => {
  Sortable.create(el, {
    handle: '.drag-handle',
    draggable: '.panel-info',
    animation: 150,
  })
});

const state = {};

// data bind title to label input
function updateTitle(event) {
  const {value, dataset} = event.target;

  document.getElementById(dataset.bind).textContent = value;
}

d.querySelectorAll('[data-bind]')
.forEach(input => input.addEventListener('input', updateTitle));


// add new elements
function setNewInputs(row, n) {
  row.id = '';
  row.className = 'panel panel-info';

  row.querySelectorAll('input').forEach(input => {
    input.id = input.name + n;
    input.name = input.name + n;
  });
  row.querySelectorAll('label').forEach(label => label.htmlFor = label.htmlFor + n);
  row.querySelector('.fa-plus').className = 'fa fa-ellipsis-v fa-lg fa-fw'
  row.querySelector('.new-sort').value = n;
  row.querySelector('.new-title').id = `title_new_${n}`;

  const inputAnchor = row.querySelector('.new-button');
  inputAnchor.className = '';
  inputAnchor.href = `#collapse_new_${n}`;

  const inputPanel = row.querySelector('.new-panel');
  inputPanel.id = `collapse_new_${n}`;
  inputPanel.classList.add('in');

  const inputName = row.querySelector('.new-name');
  inputName.dataset.bind = `title_new_${n}`;
  inputName.addEventListener('input', updateTitle);

  return row;
}

function cloneInput(event) {

  const targetID = event.target.dataset.newInput;

  const container = d.getElementById(targetID);
  const cloned = d.getElementById(`${targetID}_template`).cloneNode(true);
  const newSort = container.childElementCount;

  container.append(setNewInputs(cloned, newSort));
}

d.querySelectorAll('[data-new-input]')
.forEach(btn => {
  btn.addEventListener('click', cloneInput)
})

}(jQuery, document));
