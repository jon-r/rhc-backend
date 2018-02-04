(function($, d) {

// sortable elements
d.querySelectorAll('[data-sortable]')
.forEach(el => {
  Sortable.create(el, {
    handle: '.drag-handle'
  })
});

const state = {};

// data bind title to label input
function updateTitle(event) {
  const {value, dataset} = event.target;

  document.getElementById(dataset.bind).textContent = value;
}

d.querySelectorAll('[data-bind]')
.forEach(input => {
  input.addEventListener('input', updateTitle);
});


// add new elements
function setNewInput(input, n) {
  input.id = '';
  input.className = 'panel panel-info';

  const inputAnchor = input.getElementsByClassName('new-button')[0];
  inputAnchor.className = '';
  inputAnchor.href = `#collapse_new_${n}`;

  const inputTitle = input.getElementsByClassName('new-title')[0];
  inputTitle.textContent = '';
  inputTitle.id = `title_new_${n}`

  const inputPanel = input.getElementsByClassName('new-panel')[0]
  inputPanel.id = `collapse_new_${n}`;
  inputPanel.classList.add('in');

  const inputName = input.getElementsByClassName('new-name')[0];
  inputName.dataset.bind = `title_new_${n}`;
  inputName.addEventListener('input', updateTitle);

  input.getElementsByClassName('fa-plus')[0].className = 'fa fa-ellipsis-v fa-lg fa-fw'
  input.getElementsByClassName('new-sort')[0].value = n;


  return input;
}

function cloneInput(event) {

  const targetID = event.target.dataset.newInput;

  const container = d.getElementById(targetID);
  const cloned = d.getElementById(`${targetID}_template`).cloneNode(true);
  const newSort = container.childElementCount;

  container.append(setNewInput(cloned, newSort));
}

d.querySelectorAll('[data-new-input]')
.forEach(btn => {
  btn.addEventListener('click', cloneInput)
})

}(jQuery, document));
