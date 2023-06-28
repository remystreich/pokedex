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

<body class="bg-gradient-to-b from-lime-200 via-green-200 to-emerald-300 min-h-screen">
    <?php
    include './views/layouts/_header.php'
    ?>
    <main>
        <section >
            <div class="flex flex-col items-center justify-center px-6 py-8 mx-auto md:h-screen lg:py-0">
                <div class="w-full bg-emerald-400 rounded-lg shadow md:mt-0 sm:max-w-md xl:p-0">
                    <div class="p-6 space-y-4 md:space-y-6 sm:p-8">
                        <?php
                        switch ($version) {
                            case 'pokemon':
                                echo ' <h1 class="text-xl font-bold leading-tight tracking-tight text-gray-900 md:text-2xl">Mise à jour de ' . $data['name'] . '</h1>
                                            <form class="space-y-4 md:space-y-6" action="" method="post" enctype="multipart/form-data" >';
                                echo '<p class="text-red-500">' . $errors['name'] . '</p>';
                                echo $form->input('name', 'text', 'Nom');
                                echo '<p class="text-red-500">' . $errors['type'] . '</p>';
                                echo $form->input('type', 'text', 'Type');
                                echo '<p class="text-red-500">' . $errors['image'] . '</p>';
                                echo $form->input('image', 'file', 'Image');
                                echo $form->submit();
                                echo '</form>';
                                break;

                            case 'user':
                                echo ' <h1 class="text-xl font-bold leading-tight tracking-tight text-gray-900 md:text-2xl">Mise à jour du compte : ' . $data['name'] . '</h1>
                                            <form class="space-y-4 md:space-y-6" action="" method="post">';
                                            echo '<p class="text-red-500">' . $errors['name'] . '</p>';
                                            echo $form->input('name', 'text','Nom');
                                            echo '<p class="text-red-500">' . $errors['email'] . '</p>';
                                            echo '<p class="text-red-500">' . $errors['email2'] . '</p>';
                                            echo $form->input('email', 'text','Email');
                                            echo '<p class="text-red-500">' . $errors['password2'] . '</p>';
                                            echo $form->input('newPassword', 'password','Mot de passe');
                                            echo '<p class="text-red-500">' . $errors['password1'] . '</p>';
                                            echo $form->input('confirmPassword', 'password','Confirmer le mot de passe');
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
    <script src="https://cdnjs.cloudflare.com/ajax/libs/flowbite/1.6.6/flowbite.min.js"></script>

</body>

</html>