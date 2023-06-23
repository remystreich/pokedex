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

<body >
    <main >
    <section class="bg-gradient-to-b from-lime-200 via-green-200 to-emerald-300">
        <div class="flex flex-col items-center justify-center px-6 py-8 mx-auto md:h-screen lg:py-0">
            <a href="" class="flex items-center mb-6 text-2xl font-semibold text-gray-900 ">
                <img class="w-8 h-8 mr-2" src="../assets/img/Pokéball-removebg-preview.png" alt="logo">
                Pokédex
            </a>
            <div class="w-full bg-emerald-400 rounded-lg shadow dark:border md:mt-0 sm:max-w-md xl:p-0">
                <div class="p-6 space-y-4 md:space-y-6 sm:p-8">
                    <h1 class="text-xl font-bold leading-tight tracking-tight text-gray-900 md:text-2xl">
                        Création de compte
                    </h1>
                    <form class="space-y-4 md:space-y-6" action="" method="post">
                        <?php
                        echo '<p class="text-red-500">' . $errors['name'] . '</p>';
                        echo $form->input('name', 'text','Nom', $post['name']);
                        echo '<p class="text-red-500">' . $errors['email'] . '</p>';
                        echo '<p class="text-red-500">' . $errors['email2'] . '</p>';
                        echo $form->input('email', 'text','Email', $post['email']);
                        echo '<p class="text-red-500">' . $errors['password2'] . '</p>';
                        echo $form->input('password', 'password','Mot de passe',$post['password']);
                        echo '<p class="text-red-500">' . $errors['password1'] . '</p>';
                        echo $form->input('confirmPassword', 'password','Confirmer le mot de passe',$post['confirmPassword']);
                        echo $form->submit();
                        ?>
                        <p class="text-sm font-light text-gray-500 ">
                            Vous avez déjà un compte? <a href="#" class="font-medium text-primary-600 hover:underline ">Login</a>
                        </p>
                    </form>
                </div>
            </div>
        </div>
    </section>
    </main>
</body>

</html>