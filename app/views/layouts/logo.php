<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <script>
        function setViewportVars() {
            let width = window.innerWidth;
            let height = window.innerHeight;
            if (width * 10 < (height << 4)) {
                height = (width * 10) >>> 4;
            } else if (width * 10 > (height << 4)) {
                width = (height << 4) / 10;
            }
            document.documentElement.style.setProperty("--vw", width + "px");
            document.documentElement.style.setProperty("--vh", height + "px");
        }
        setViewportVars();
        // Prevent multiple initializations
        if (window.pageResizeInitialized) {
            console.log("Page navigation already initialized, skipping...");
        } else {
            window.pageResizeInitialized = true;
            initPageNavigation();
        }

        function initPageNavigation() {
            window.addEventListener("resize", setViewportVars);
        }
    </script>
    <link rel="stylesheet" href="<?php echo base_url('css/styles.css') ?>" />
    <link rel="icon" href="data:;" />
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link
        href="https://fonts.googleapis.com/css2?family=Bonheur+Royale&family=Wendy+One&display=swap"
        rel="stylesheet" />
    <title>Logo page</title>
</head>

<body>
    <div class="logo">
        <div class="contrasting circle" id="circlePage1"></div>
        <div class="author">by Eduard Abajyan</div>
        <div class="portfolioWord1">PORTFOLIO</div>
        <div class="portfolioWord2">PORTFOLIO</div>
        <div class="projectWord">project</div>
    </div>
    <script src="<?php echo base_url('js/pageListings.js') ?>"></script>
</body>

</html>