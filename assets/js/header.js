document.addEventListener('DOMContentLoaded', () => {
  const burger   = document.querySelector('.header-burger');
  const mobile   = document.querySelector('.mobile-nav');
  const backdrop = document.querySelector('.mobile-nav__backdrop');
  const closeBtn = document.querySelector('.mobile-close');

  if (!burger || !mobile) return;

  const open = () => { mobile.classList.add('active'); document.body.style.overflow = 'hidden'; };
  const close = () => { mobile.classList.remove('active'); document.body.style.overflow = ''; };

  burger.addEventListener('click', open);
  closeBtn?.addEventListener('click', close);
  backdrop?.addEventListener('click', close);
});
