// Prevent multiple initializations
if (window.pageNavigationInitialized) {
  console.log('Page navigation already initialized, skipping...');
} else {
  window.pageNavigationInitialized = true;
  initPageNavigation();
}

function initPageNavigation() {
const scrollY = window.scrollY;

function nextpage() {
  const currentUrl = window.location.href;
  const regExp = /http:\/\/eduardabajyan\.local\/page(\d+)/;
  const match = currentUrl.match(regExp);
  let currentPage = match ? parseInt(match[1]) : 0;
  if (currentPage === 6) {
    window.location.href = "http://eduardabajyan.local/";
    console.log(currentPage);
    return;
  }
  window.location.href = `http://eduardabajyan.local/page${++currentPage}`;
}

function previouspage() {
  const currentUrl = window.location.href;
  const regExp = /http:\/\/eduardabajyan\.local\/page(\d+)/;
  const match = currentUrl.match(regExp);
  const currentPage = match ? parseInt(match[1]) : 1;
  const prevPage = Math.max(1, currentPage - 1);
  window.location.href = `http://eduardabajyan.local/page${prevPage}`;
}

// Touch swipe detection
let touchStartX = 0;

// Scroll detection with proper debouncing and cooldown
let scrollTimeout;
let isScrolling = false;
const SCROLL_COOLDOWN = 100; // Cooldown period in ms
const SCROLL_THRESHOLD = 50; // Minimum delta to trigger

// Touch swipe detection
document.body.addEventListener(
  "touchstart",
  (e) => {
    touchStartX = e.touches[0].clientX;
  },
  { passive: true }
);

document.body.addEventListener(
  "touchend",
  (e) => {
    const touchEndX = e.changedTouches[0].clientX;
    const diff = touchEndX - touchStartX;

    if (diff > 100) {
      // Swipe down
      previouspage();
    } else if (diff < -100) {
      // Swipe up
      nextpage();
    }
  },
  { passive: true }
);

// Keyboard arrow keys
document.addEventListener("keydown", (e) => {
  if (e.key === "ArrowUp" || e.key === "ArrowLeft") {
    previouspage();
  } else if (e.key === "ArrowDown" || e.key === "ArrowRight") {
    nextpage();
  }
});
// Mouse wheel / trackpad scrolling
let lastScrollTime = 0;

window.addEventListener('wheel', (e) => {
  const now = Date.now();
  
  // Check if enough time has passed since last scroll
  if (now - lastScrollTime < SCROLL_COOLDOWN) {
    return;
  }
  
  // Horizontal scroll detection
  if (Math.abs(e.deltaX) > Math.abs(e.deltaY)) {
    if (Math.abs(e.deltaX) > SCROLL_THRESHOLD) {
      lastScrollTime = now;
      
      if (e.deltaX > 0) {
        // Scrolling right
        nextpage();
      } else {
        // Scrolling left
        previouspage();
      }
    }
  }
}, { passive: true });

} // End of initPageNavigation