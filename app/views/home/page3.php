<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="icon" href="data:;" />
    <script>
        function setViewportVars() {
            document.documentElement.style.setProperty(
                "--vw",
                window.innerWidth + "px"
            );
            document.documentElement.style.setProperty(
                "--vh",
                window.innerHeight + "px"
            );
        }
        setViewportVars();
        window.addEventListener("resize", setViewportVars);
    </script>
    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css"
        rel="stylesheet"
        integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB"
        crossorigin="anonymous" />
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link
        href="https://fonts.googleapis.com/css2?family=Akaya+Telivigala&family=Cagliostro&family=Corinthia:wght@400;700&family=Niconne&display=swap"
        rel="stylesheet" />
    <link rel="stylesheet" href="<?php echo base_url('css/styles.css') ?>" />
    <title>About Me</title>
</head>

<body>
    <div class="container-fluid page3">
        <div class="row">
            <div
                class="contrasting col-12 col-md-4 col-lg-6"
                id="introductionAboutMe">
                <p id="introductionAboutMeWord">introducing</p>
                <h1>About Me</h1>
                <p>
                    Hello! I'm Eduard, a passionate full-stack web developer dedicated
                    to bringing your digital vision to life. With expertise in creating
                    seamless, user-friendly experiences, I'm here to transform your
                    ideas into reality. Let's collaborate and build something
                    extraordinary together!
                </p>
            </div>
            <div class="col-12 col-md-8 col-lg-6" id="imageAboutMe">
                <div class="frame">
                    <img src="<?php echo base_url('images/aboutMeImage.jpg') ?>" alt="About Me Image" />
                    <div>
                        <p class="name">Eduard Abajyan</p>
                        <p class="profession">full-stack web developer</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        function resizeAboutMeImage() {
            let containerWidth =
                document.getElementById("imageAboutMe").offsetWidth;
            let containerHeight =
                document.getElementById("imageAboutMe").offsetHeight;
            let imageWidth = (containerWidth >>> 3) * 7;
            let imageHeight = (containerHeight >>> 3) * 7;

            if (containerWidth * 4 > containerHeight * 3)
                imageWidth = (imageHeight * 3) >>> 2;
            else if (containerWidth * 4 < containerHeight * 3)
                imageHeight = (imageWidth << 2) / 3;

            let img = document.querySelector("#imageAboutMe .frame img");
            img.style.width = imageWidth + "px";
            img.style.height = imageHeight + "px";
        }
        resizeAboutMeImage();
        window.addEventListener("resize", resizeAboutMeImage);
    </script>
    <script src="<?php echo base_url('js/pageListings.js') ?>"></script>

</body>

</html>