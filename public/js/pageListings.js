// Prevent multiple initializations
if (window.pageNavigationInitialized) {
  console.log("Page navigation already initialized, skipping...");
} else {
  window.pageNavigationInitialized = true;
  initPageNavigation();
}

function initPageNavigation() {
  const scrollY = window.scrollY;
  document.body.style.position = "fixed";
  document.body.style.top = `-${scrollY}px`;

  function nextpage() {
    const currentUrl = window.location.href;
    const regExp = /http:\/\/eduardabajyan\.local\/page(\d+)/;
    const match = currentUrl.match(regExp);
    let currentPage = match ? parseInt(match[1]) : 0;
    if (currentPage === 5) {
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
  let touchStartY = 0;

  // Scroll detection with proper debouncing and cooldown
  let scrollTimeout;
  let isScrolling = false;
  const SCROLL_COOLDOWN = 100; // Cooldown period in ms
  const SCROLL_THRESHOLD = 50; // Minimum delta to trigger

  document.addEventListener(
    "wheel",
    (e) => {
      // Prevent default scroll behavior
      e.preventDefault();

      // If already scrolling, ignore
      if (isScrolling) return;

      // Normalize deltaY for cross-browser compatibility
      const delta = Math.sign(e.deltaY);
      const absDelta = Math.abs(e.deltaY);
      const deltaX = Math.sign(e.deltaX);
      const absDeltaX = Math.abs(e.deltaX);

      // Check for horizontal scroll
      if (absDeltaX > SCROLL_THRESHOLD && absDeltaX > absDelta) {
        if (deltaX > 0) {
          // Scroll right
          nextpage();
        } else if (deltaX < 0) {
          // Scroll left
          previouspage();
        }
        return;
      }

      // Only trigger if scroll is significant enough
      if (absDelta < SCROLL_THRESHOLD) return;

      clearTimeout(scrollTimeout);
      scrollTimeout = setTimeout(() => {
        isScrolling = true;

        if (delta > 0) {
          // Scroll down
          nextpage();
        } else if (delta < 0) {
          // Scroll up
          previouspage();
        }

        // Reset cooldown
        setTimeout(() => {
          isScrolling = false;
        }, SCROLL_COOLDOWN);
      }, 150);
    },
    { passive: false }
  );

  // Touch swipe detection
  document.body.addEventListener(
    "touchstart",
    (e) => {
      touchStartY = e.touches[0].clientY;
    },
    { passive: true }
  );

  document.body.addEventListener(
    "touchend",
    (e) => {
      const touchEndY = e.changedTouches[0].clientY;
      const diff = touchEndY - touchStartY;

      if (diff > 50) {
        // Swipe down
        previouspage();
      } else if (diff < -50) {
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
} // End of initPageNavigation
