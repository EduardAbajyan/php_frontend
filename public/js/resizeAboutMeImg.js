function resizeAboutMeImage() {
  const imageContainer = document.getElementById("imageAboutMe");
  if (!imageContainer) return;

  let containerWidth = imageContainer.offsetWidth;
  let containerHeight = imageContainer.offsetHeight;
  let imageWidth = (containerWidth >>> 3) * 7;
  let imageHeight = (containerHeight >>> 3) * 7;

  if (containerWidth * 4 > containerHeight * 3)
    imageWidth = (imageHeight * 3) >>> 2;
  else if (containerWidth * 4 < containerHeight * 3)
    imageHeight = (imageWidth << 2) / 3;

  let img = document.querySelector("#imageAboutMe .frame img");
  if (!img) return;

  img.style.width = imageWidth + "px";
  img.style.height = imageHeight + "px";
  img.classList.remove("aboutme-needs-size");
  img.classList.add("aboutme-sized");
}
document.addEventListener("DOMContentLoaded", function () {
  requestAnimationFrame(() => {
    resizeAboutMeImage();
  });

  window.addEventListener("resize", resizeAboutMeImage);
  window.addEventListener("load", resizeAboutMeImage);
});