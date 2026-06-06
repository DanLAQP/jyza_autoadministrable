const elementsToAnimate = document.querySelectorAll('.animado');
const observer = new IntersectionObserver((entries) => {
    entries.forEach(entry => {
        if (entry.isIntersecting) {
            entry.target.classList.add('visible');
        } else {
            entry.target.classList.remove('visible');
        }
    });
}, { threshold: 0.5 }); 
elementsToAnimate.forEach(element => {
    observer.observe(element);
});