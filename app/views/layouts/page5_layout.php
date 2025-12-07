<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="icon" href="data:;" />
    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css"
        rel="stylesheet"
        integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB"
        crossorigin="anonymous" />
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link
        href="https://fonts.googleapis.com/css2?family=Bonheur+Royale&family=Cagliostro&family=Wendy+One&display=swap"
        rel="stylesheet" />
    <link rel="stylesheet" href="<?php echo base_url('css/styles.css') ?>" />
    <title>Skills</title>
</head>

<body>
    <div class="container-fluid page5">
        <div class="row">
            <div class="col-12 col-md-4 col-lg-3" id="skillsHeader">
                <h2>Skills</h2>
            </div>
            <?php echo $content; ?>
        </div>
    </div>
    <script>
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
    </script>
    <script src="<?php echo base_url('js/pageListingsNoScrolling.js') ?>"></script>
</body>

</html>