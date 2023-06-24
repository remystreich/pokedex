<?php
session_start();
$form = new Form();
?>
<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gradient-to-b from-lime-200 via-green-200 to-emerald-300 min-h-screen">
    <?php
    include './views/layouts/_header.php'
    ?>
    <main>
    <section class="bg-transparent">
       
        <div class="flex flex-col items-center justify-center px-6 py-8 mx-auto md:h-screen lg:py-0">
        <?php
            if ($success) {
                echo '<p class="text-emerald-500 text-3xl pb-8">' . $success . '</p>';
            }
        ?>
            <div class="w-full bg-emerald-400 rounded-lg shadow dark:border md:mt-0 sm:max-w-md xl:p-0">
                <div class="p-6 space-y-4 md:space-y-6 sm:p-8">
                    <h1 class="text-xl font-bold leading-tight tracking-tight text-gray-900 md:text-2xl">
                        Entrer le nom du pokémon à ajouter
                    </h1>
                    <form class="space-y-4 md:space-y-6" action="" method="post">
                        <?php
                        if ($e) {
                            echo '<p class="text-red-500">' . $e->getMessage() . '</p>';
                        }
                        
                        echo $form->input('pokemon', 'text','Nom du pokémon', $post['pokemon']);
                        echo $form->submit();
                        ?>
                    </form>
                </div>
            </div>
        </div>
    </section>
    </main>
</body>

</html>