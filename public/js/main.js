// Event listner on scroll.
const navigationRight = document.querySelector(".back-top");
console.log(navigationRight)
document.addEventListener("scroll", function () {
   
  if (window.scrollY > 200) {
    navigationRight.classList.remove("hide");
  } else {
    navigationRight.classList.add("hide");
  }
});
