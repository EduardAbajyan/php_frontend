window.addEventListener("load", () => {
  const listingsElement = document.getElementById("listings");
  const widthOfListings = listingsElement.offsetWidth - 120;
  let list = document.querySelectorAll("#listings svg");
  list[0].style.width = parseInt((widthOfListings * 23) / 100) + "px";
  list[0].style.height = parseInt(1.5 * parseFloat(list[0].style.width)) + "px";
  list[1].style.width = parseInt((widthOfListings * 33) / 100) + "px";
  list[1].style.height = parseFloat(list[1].style.width) + "px";
  list[2].style.width = parseInt((widthOfListings * 43) / 100) + "px";
  list[2].style.height = parseInt(0.8 * parseFloat(list[2].style.width)) + "px";
  list.forEach((item) => {
    console.log(item);
    console.log("Width: " + item.style.width);
    console.log("Height: " + item.style.height);
  });
  setTimeout(() => {
    if (listingsElement) {
      listingsElement.remove();
    }
  }, 7000);
});
