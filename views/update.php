<?php
session_start();
$form = new Form($data);
?>
<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/rippleui@1.12.1/dist/css/styles.css" />
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body>
    <main>
        <section class="bg-gradient-to-b from-lime-200 via-green-200 to-emerald-300">
            <div class="flex flex-col items-center justify-center px-6 py-8 mx-auto md:h-screen lg:py-0">
                <div class="w-full bg-emerald-400 rounded-lg shadow dark:border md:mt-0 sm:max-w-md xl:p-0">
                    <div class="p-6 space-y-4 md:space-y-6 sm:p-8">
                        <?php
                        switch ($version) {
                            case 'pokemon':
                                echo ' <h1 class="text-xl font-bold leading-tight tracking-tight text-gray-900 md:text-2xl">Mise à jour de ' . $name . '</h1>
                                            <form class="space-y-4 md:space-y-6" action="" method="post" enctype="multipart/form-data" >';
                                echo $form->input('name', 'text', 'Nom');
                                echo $form->input('type', 'text', 'Type');
                                echo $form->input('image', 'file', 'Image');
                                echo $form->submit();
                                echo '</form>';
                                break;

                            case 'user':
                                echo ' <h1 class="text-xl font-bold leading-tight tracking-tight text-gray-900 md:text-2xl">Mise à jour de ' . $name . '</h1>
                                            <form class="space-y-4 md:space-y-6" action="" method="post">';
                                echo $form->input('name', 'text', 'Nom');
                                echo $form->input('email', 'text', 'Email');
                                echo $form->input('password', 'password', 'Mot de passe');
                                echo $form->submit();
                                echo '</form>';
                                break;
                        }
                        ?>
                    </div>
                </div>
            </div>
        </section>
    </main>
</body>

</html>