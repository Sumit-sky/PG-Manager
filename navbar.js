const toggle = document.querySelector(".toggle");
const navbar = document.querySelector(".navbar");
/* Toggle mobile navbar */
function togglenavbar() {
    if (navbar.classList.contains("active")) {
        navbar.classList.remove("active");
        
        // adds the navbar (hamburger) icon 
        toggle.querySelector("a").innerHTML = "<i class='fas fa-bars'></i>";
    } else {
        navbar.classList.add("active");
        
        // adds the close (x) icon 
        toggle.querySelector("a").innerHTML = "<i class='fas fa-times'></i>";
    }
}
/* Event Listener */
toggle.addEventListener("click", togglenavbar, false);


const items = document.querySelectorAll(".item");
/* Activate Subnavbar */
function toggleItem() {
  if (this.classList.contains("subnavbar-active")) {
    this.classList.remove("subnavbar-active");
  } else if (navbar.querySelector(".subnavbar-active")) {
    navbar.querySelector(".subnavbar-active").classList.remove("subnavbar-active");
    this.classList.add("subnavbar-active");
  } else {
    this.classList.add("subnavbar-active");
  }
}
/* Event Listeners */
for (let item of items) {
    if (item.querySelector(".subnavbar")) {
      item.addEventListener("click", toggleItem, false);
      item.addEventListener("keypress", toggleItem, false);
    }   
}



function closeSubnavbar(e) {
    if (navbar.querySelector(".subnavbar-active")) {
      let isClickInside = navbar
        .querySelector(".subnavbar-active")
        .contains(e.target);
      if (!isClickInside && navbar.querySelector(".subnavbar-active")) {
        navbar.querySelector(".subnavbar-active").classList.remove("subnavbar-active");
      }
    }
  }
  /* Event listener */
  document.addEventListener("click", closeSubnavbar, false);