  </main>
  <footer class="main-footer">
    <div class="footer-content">
      <div class="footer-section about">
        <h3>Re∫olve_App</h3>
        <p>La aplicación definitiva para resolver integrales y dominar el cálculo diferencial e integral.</p>
        <div class="social-icons">
          <a href="https://youtube.com/@alejandrococa?si=opBpbQpj215ua2eZ" target="_black"><i class="fab fa-youtube"></i></a>
        </div>
      </div>
      
      <div class="footer-section links">
        <h3>Enlaces rápidos</h3>
        <ul>
          <li><a href="index.php">Inicio</a></li>
          <li><a href="DESCARGA.php">Descargar</a></li>
          <li><a href="USO.php">Tutoriales</a></li>
          <li><a href="_CON.php">Soporte</a></li>
        </ul>
      </div>
      
      <div class="footer-section contact">
        <h3>Contacto</h3>
        <p><i class="fas fa-envelope"></i> resolveappasistencia@gmail.com</p>
        <p><i class="fas fa-phone"></i> +55 5951 7067</p>
      </div>
    </div>
    
    <div class="footer-bottom">
      <p>&copy; 2025 Re∫olve_App - Todos los derechos reservados</p>
      <p>Creditos a :Alejandro Coca Santillana | <a href="terminos.php">Términos y condiciones</a> 
    </div>
  </footer>
  
  <script>
document.addEventListener('DOMContentLoaded', function() {
  const carousel = document.querySelector('.carousel-inner');
  const items = document.querySelectorAll('.carousel-item');
  const prevBtn = document.querySelector('.carousel-control.prev');
  const nextBtn = document.querySelector('.carousel-control.next');
  const indicators = document.querySelectorAll('.indicator');
  let currentIndex = 0;
  const itemCount = items.length;

  // Función para actualizar el carrusel
  function updateCarousel() {
    const offset = -currentIndex * 100;
    carousel.style.transform = `translateX(${offset}%)`;
    
    // Actualizar indicadores
    indicators.forEach((indicator, index) => {
      indicator.classList.toggle('active', index === currentIndex);
    });
  }

  // Event listeners para controles
  prevBtn.addEventListener('click', () => {
    currentIndex = (currentIndex > 0) ? currentIndex - 1 : itemCount - 1;
    updateCarousel();
  });

  nextBtn.addEventListener('click', () => {
    currentIndex = (currentIndex < itemCount - 1) ? currentIndex + 1 : 0;
    updateCarousel();
  });

  // Event listeners para indicadores
  indicators.forEach(indicator => {
    indicator.addEventListener('click', () => {
      currentIndex = parseInt(indicator.dataset.index);
      updateCarousel();
    });
  });

  // Auto-avance cada 5 segundos
  setInterval(() => {
    currentIndex = (currentIndex < itemCount - 1) ? currentIndex + 1 : 0;
    updateCarousel();
  }, 5000);
});
</script>
</body>
</html>