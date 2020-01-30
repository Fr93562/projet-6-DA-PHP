// Utilisation du plugin scrollReveal sur les articles et le footer
window.sr = ScrollReveal({ reset: false });
sr.reveal('.bar', { duration: 400 });  
sr.reveal('.contenairDiv', { duration: 1000 });
sr.reveal('.contenairComment', { duration: 1000 });


// Appelle la librairie Siema pour le carousel 
const siemas = document.querySelectorAll('.siema');

	for(const siema of siemas) {
  new Siema({
    selector: siema
  })
}