// Prevent multiple initializations
if (window.pageListingsNoScrollInitialized) {
  console.log("Page navigation already initialized, skipping...");
} else {
  window.pageListingsNoScrollInitialized = true;
  initPageNavigation();
}

function initPageNavigation() {
  // Single navigation gate to prevent double/rapid triggers
  let isNavigating = false;
  const NAVIGATION_COOLDOWN = 600; // ms - increased cooldown
  const MIN_PAGE = 1;
  const MAX_PAGE = 6;

  // Wheel event handling constants
  const WHEEL_DEBOUNCE = 150; // ms
  const WHEEL_THRESHOLD = 50; // Minimum delta to trigger
  let wheelTimeout = null;

  // Touch swipe constants
  const TOUCH_SWIPE_THRESHOLD = 100; // Minimum horizontal swipe distance to trigger

  function getBaseUrl() {
    const protocol = window.location.protocol;
    const host = window.location.host;
    return `${protocol}//${host}`;
  }

  function getCurrentPage() {
    const path = window.location.pathname;
    const match = path.match(/\/page(\d+)/);
    return match ? parseInt(match[1]) : 1;
  }

  function navigateToPage(page) {
    if (isNavigating) return;

    isNavigating = true;
    const baseUrl = getBaseUrl();

    if (page < MIN_PAGE) {
      page = MIN_PAGE;
    } else if (page > MAX_PAGE) {
      // Loop back to page1 when going past max
      page = MIN_PAGE;
    }

    window.location.href = `${baseUrl}/page${page}`;

    // Reset gate after cooldown (in case navigation is cancelled)
    setTimeout(() => {
      isNavigating = false;
    }, NAVIGATION_COOLDOWN);
  }

  function nextpage() {
    const currentPage = getCurrentPage();
    navigateToPage(currentPage + 1);
  }

  function previouspage() {
    const currentPage = getCurrentPage();
    navigateToPage(currentPage - 1);
  }

  // Touch swipe detection
  let touchStartX = 0;

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
      if (isNavigating) return;

      const touchEndX = e.changedTouches[0].clientX;
      const diff = touchEndX - touchStartX;

      if (Math.abs(diff) > TOUCH_SWIPE_THRESHOLD) {
        if (diff > 0) {
          // Swipe right
          previouspage();
        } else {
          // Swipe left
          nextpage();
        }
      }
    },
    { passive: true }
  );

  // Keyboard arrow keys
  document.addEventListener("keydown", (e) => {
    if (isNavigating) return;

    if (e.key === "ArrowUp" || e.key === "ArrowLeft") {
      previouspage();
    } else if (e.key === "ArrowDown" || e.key === "ArrowRight") {
      nextpage();
    }
  });

  let wheelDeltaAccumulatorX = 0;
  let wheelDeltaAccumulatorY = 0;
  // Mouse wheel / trackpad scrolling
  window.addEventListener(
    "wheel",
    (e) => {
      if (isNavigating) return;

      // Accumulate wheel delta
      wheelDeltaAccumulatorX += e.deltaX;
      wheelDeltaAccumulatorY += e.deltaY;

      // Clear existing timeout
      if (wheelTimeout) {
        clearTimeout(wheelTimeout);
      }

      // Set a timeout to reset the wheel delta accumulator
      wheelTimeout = setTimeout(() => {
        if (
          Math.abs(wheelDeltaAccumulatorX) > Math.abs(wheelDeltaAccumulatorY)
        ) {
          if (Math.abs(wheelDeltaAccumulatorX) > WHEEL_THRESHOLD) {
            if (wheelDeltaAccumulatorX > 0) {
              // Scrolling right
              nextpage();
            } else {
              // Scrolling left
              previouspage();
            }
          }
        }
        wheelDeltaAccumulator = 0;
        wheelTimeout = null;
      }, WHEEL_DEBOUNCE);

      // Horizontal scroll detection
    },
    { passive: true }
  );
} // End of initPageNavigation
