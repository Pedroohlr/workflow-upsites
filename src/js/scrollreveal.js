/**
 * ScrollReveal - Animações on scroll
 * 
 * Este arquivo será compilado separadamente
 * Importar bibliotecas de animação aqui se necessário
 */

(($) => {
  'use strict';

  $(() => {
    // Exemplo: Adicione animações fade-in ao scroll
    const animateOnScroll = () => {
      const elements = document.querySelectorAll('[data-animate]');

      const observer = new IntersectionObserver((entries) => {
        entries.forEach((entry) => {
          if (entry.isIntersecting) {
            entry.target.classList.add('animated');
            observer.unobserve(entry.target);
          }
        });
      }, {
        threshold: 0.1,
        rootMargin: '0px 0px -50px 0px'
      });

      elements.forEach((el) => observer.observe(el));
    };

    // Inicializa animações
    if (document.querySelectorAll('[data-animate]').length > 0) {
      animateOnScroll();
    }

    // Exemplo de uso:
    // <div data-animate class="fade-up">Conteúdo</div>
  });
})(jQuery);

