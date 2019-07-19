const btn = document.querySelector('#menu');

const even = () => {
  btn.addEventListener('click', () => {
    document.body.classList.toggle("with")
  });
}

even();