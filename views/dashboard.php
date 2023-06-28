<?php
session_start();

?>
<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://kit.fontawesome.com/463c3f4f8a.js" crossorigin="anonymous"></script>
</head>

<body class="bg-gradient-to-r from-cyan-300 via-blue-300 to-indigo-300  ">
    <?php
    include './views/layouts/_header.php'
    ?>
    <main>

        <!-- Container for demo purpose -->
        <div class="container my-24 mx-auto md:px-6">
            <!-- Section: Design Block -->
            <section class="mb-32 text-center">
                <h2 class="mb-12 text-3xl font-bold">
                    Pokédex
                </h2>
                <?php
                if ($e) {
                    echo '<p class="text-red-500 text-3xl my-5">' . $e->getMessage() . '</p>';
                }
                ?>
                <div class="lg:gap-xl-12 grid gap-x-6 gap-y-6 md:grid-cols-2 lg:grid-cols-4">
                    <?php
                    foreach ($pokemons as $pokemon) {

                        include './views/layouts/_pokeCard.php';
                    }
                    ?>
                </div>
            </section>
            <!-- Section: Design Block -->
        </div>
        <!-- Container for demo purpose -->
    </main>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/flowbite/1.6.6/flowbite.min.js"></script>

</body>

</html>