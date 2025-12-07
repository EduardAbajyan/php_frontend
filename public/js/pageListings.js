// Prevent multiple initializations
if (window.pageListingsInitialized) {
  console.log("Page navigation already initialized, skipping...");
} else {
  window.pageListingsInitialized = true;
  initPageNavigation();
}

function initPageNavigation() {
  const scrollY = window.scrollY;
  document.body.style.position = "fixed";
  document.body.style.top = `-${scrollY}px`;

  // Single navigation gate to prevent double/rapid triggers
  let isNavigating = false;
  const NAVIGATION_COOLDOWN = 600; // ms - increased cooldown
  const MIN_PAGE = 1;
  const MAX_PAGE = 6;
  
  // Wheel event handling constants
  const WHEEL_DEBOUNCE = 150; // ms
  const WHEEL_THRESHOLD = 50; // Minimum accumulated delta to trigger
  
  // Touch swipe constants
  const TOUCH_SWIPE_THRESHOLD = 50; // Minimum swipe distance to trigger

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
  let touchStartY = 0;

  // Wheel event handling with debouncing
  let wheelDeltaAccumulator = 0;
  let wheelTimeout = null;

  document.addEventListener(
    "wheel",
    (e) => {
      e.preventDefault();

      if (isNavigating) return;

      // Accumulate wheel delta
      wheelDeltaAccumulator += e.deltaY;
      
      // Clear existing timeout
      if (wheelTimeout) {
        clearTimeout(wheelTimeout);
      }

      // Set new timeout to process accumulated delta
      wheelTimeout = setTimeout(() => {
        if (Math.abs(wheelDeltaAccumulator) >= WHEEL_THRESHOLD) {
          if (wheelDeltaAccumulator > 0) {
            nextpage();
          } else {
            previouspage();
          }
        }
        // Reset accumulator
        wheelDeltaAccumulator = 0;
        wheelTimeout = null;
      }, WHEEL_DEBOUNCE);
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
      if (isNavigating) return;
      
      const touchEndY = e.changedTouches[0].clientY;
      const diff = touchEndY - touchStartY;

      if (Math.abs(diff) > TOUCH_SWIPE_THRESHOLD) {
        if (diff > 0) {
          // Swipe down
          previouspage();
        } else {
          // Swipe up
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
} // End of initPageNavigation
