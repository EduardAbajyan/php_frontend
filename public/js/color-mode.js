// Color mode based on time of day
(function () {
  "use strict";

  // Get current hour (0-23)
  const hour = new Date().getHours();

  // Determine theme based on time
  // Night: 20:00 - 05:59
  // Day: 06:00 - 19:59
  const isDayTime = hour >= 6 && hour < 19;

  // Define color schemes
  const colors = {
    day: {
      "--white": "#fffefc",
      "--beige": "#fff6e3",
      "--brown-dark": "#3f2215",
      "--brown-medium": "#8b5a3c",
    },
    night: {
      "--white": "#000103",
      "--beige": "#3f2215",
      "--brown-dark": "#fff6e3",
      "--brown-medium": "#8b5a3c",
    },
  };

  // Select appropriate color scheme
  const activeColors = isDayTime ? colors.day : colors.night;

  // Apply CSS variables to root
  const root = document.documentElement;
  for (const [property, value] of Object.entries(activeColors)) {
    root.style.setProperty(property, value);
  }

  // Store the mode for other scripts
  root.setAttribute("data-color-mode", isDayTime ? "day" : "night");
})();
