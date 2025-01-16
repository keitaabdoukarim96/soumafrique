document.addEventListener("DOMContentLoaded", function () {
    const slides = document.querySelectorAll(".carousel-slide");
    const circles = document.querySelectorAll(".circle");
    let currentIndex = 0;
  
    function showSlide(index) {
      slides.forEach((slide, i) => {
        slide.classList.toggle("hidden", i !== index);
      });
      circles.forEach((circle, i) => {
        circle.classList.toggle("active", i === index);
      });
    }
  
    function nextSlide() {
      currentIndex = (currentIndex + 1) % slides.length;
      showSlide(currentIndex);
    }
  
    // Change slide every 5 seconds
    const interval = setInterval(nextSlide, 5000);
  
    // Handle circle clicks
    circles.forEach((circle, index) => {
      circle.addEventListener("click", () => {
        clearInterval(interval); // Stop auto-slide when circle clicked
        currentIndex = index;
        showSlide(currentIndex);
      });
    });
  
    // Display the first slide initially
    showSlide(currentIndex);
  });
  