function handleCardClick() {
  console.log("Card clicked!");
}
function equalizeImageHeights() {
  const skillItems = document.querySelectorAll(
    ".page5 > .row > #skillsList > .skill-category .row ul li .card img"
  );

  let maxHeight = 0;

  skillItems.forEach((img) => {
    if (img.naturalHeight > maxHeight) {
      maxHeight = img.naturalHeight;
    }
  });

  skillItems.forEach((img) => {
    img.style.height = maxHeight + "px";
    img.style.objectFit = "cover";
  });
}
window.addEventListener("load", equalizeImageHeights);
window.addEventListener("resize", equalizeImageHeights);
