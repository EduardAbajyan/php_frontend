window.addEventListener("load", function () {
  function resizeEducationHeaderImg() {
    // Use the smaller of: container width or viewport width (for mobile)
    const educationHeader = document.getElementById("educationHeader");
    if (!educationHeader) return;

    let containerWidth = educationHeader.offsetWidth;
    let imageWidth = (containerWidth >>> 2) * 3;
    let imageHeight = imageWidth * 0.6667;

    console.log("Container width:", containerWidth);
    console.log("Calculated image width:", imageWidth);
    console.log("Calculated image height:", imageHeight);

    let imgs = document.querySelectorAll("#educationHeader img");

    imgs.forEach((img) => {
      img.style.width = imageWidth + "px";
      img.style.height = imageHeight + "px";
    });
  }

  resizeEducationHeaderImg();
  window.addEventListener("resize", resizeEducationHeaderImg);  // Calculate and set remaining height CSS variable
  function setRemainingHeight() {
    const educationHeader = document.getElementById("educationHeader");
    if (educationHeader) {
      const headerHeight = educationHeader.offsetHeight;
      const remainingHeight = window.innerHeight - headerHeight;
      document.documentElement.style.setProperty(
        "--rem-height",
        remainingHeight + "px"
      );
      console.log("Header height:", headerHeight);
      console.log("Remaining height set to:", remainingHeight + "px");
    }
  }

  // Set initial height and update on resize
  setRemainingHeight();
  window.addEventListener("resize", setRemainingHeight);

  let listItems = document.getElementsByTagName("li");
  const images = document.getElementById("imageContainer");
  const imagesUrl = images.getAttribute("data-info");
  console.log("Image container URL:", imagesUrl);
  console.log("Found list items:", listItems.length);

  for (let i = 0; i < listItems.length; i++) {
    listItems[i].addEventListener("click", function () {
      console.log("List item clicked!");
      let info = this.getAttribute("data-info");
      console.log("Data-info value:", info);
      if (info) {
        if (info.indexOf(",") === -1) {
          images.innerHTML =
            '<img src="' +
            imagesUrl +
            "/" +
            info.trim() +
            '.jpg" alt="Education Image" />';

          // Use setTimeout to ensure DOM is updated before resizing
          setTimeout(() => {
            resizeEducationHeaderImg();
          }, 0);
          console.log(images.innerHTML);

          return;
        } else {
          async function addimages(images, info) {
            images.innerHTML = "";
            for (const img of info) {
              images.innerHTML +=
                '<img src="' +
                imagesUrl +
                "/" +
                img.trim() +
                '.jpg" alt="Education Image" />';
            }
          }

          info = info.split(",");
          images.innerHTML = "";
          addimages(images, info).then(() => {
            let newImages = images.getElementsByTagName("img");
            Array.from(newImages).forEach((element) => {
              element.style.marginTop = "2vh";
              element.style.border = "1px solid #3f2215";
              element.style.borderRadius = "10px";
              element.style.transition = "all 0.4s ease";
              element.style.boxShadow = "0 4px 12px rgba(63, 34, 21, 0.15)";
              element.style.animation = "fadeInScale 0.8s ease-out";
            });
            function resizeEducationHeaderImg() {
              let container = document.getElementById("educationHeader");
              let containerWidth = container.offsetWidth;
              let imageWidth = (containerWidth >>> 2) * 3;
              let imageHeight = imageWidth * 0.6667;

              let imgs = container.getElementsByTagName("img");
              for (let img of imgs) {
                img.style.width = imageWidth + "px";
                img.style.height = imageHeight + "px";
              }
            }
            resizeEducationHeaderImg();
            window.addEventListener("resize", resizeEducationHeaderImg);
            window.addEventListener("load", resizeEducationHeaderImg);
          });
        }
      }
    });
  }
});
