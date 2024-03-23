let navbar = document.querySelector(".small-nav");
var menubtn = document.querySelector(".small-screen-icon")
menubtn.onclick = () =>{
    navbar.classList.toggle("active");
}

window.onscroll = () =>{
  navbar.classList.remove("active");
}
document.onclick = function(e){
  if (!navbar.contains(e.target) && !menubtn.contains(e.target)) {
      navbar.classList.remove("active");
  }
}