document.addEventListener("DOMContentLoaded", function () {
  function setViewportVars() {
    let width = window.innerWidth;
    let height = window.innerHeight;
    if (width * 10 < height << 4) {
      height = (width * 10) >>> 4;
    } else if (width * 10 > height << 4) {
      width = (height << 4) / 10;
    }
    document.documentElement.style.setProperty("--vw", width + "px");
    document.documentElement.style.setProperty("--vh", height + "px");
  }
  setViewportVars();
  // Prevent multiple initializations
  if (window.pageResizeInitialized) {
    console.log("Page navigation already initialized, skipping...");
  } else {
    window.pageResizeInitialized = true;
    initPageNavigation();
  }

  function initPageNavigation() {
    window.addEventListener("resize", setViewportVars);
  }
});
