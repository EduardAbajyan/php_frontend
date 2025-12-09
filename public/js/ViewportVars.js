function setViewportVars() {
  document.documentElement.style.setProperty("--vw", window.innerWidth + "px");
  document.documentElement.style.setProperty("--vh", window.innerHeight + "px");
}
setViewportVars();
window.addEventListener("resize", setViewportVars);
