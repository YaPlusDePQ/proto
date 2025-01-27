<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../default.css">
    <title>Cours</title>
</head>
<body>


    <div class="exercice-wrapper">
        <h2>Exercice</h2>
        <div class="exercice-container">
            {!! $exercices->getHTML() !!}
        </div>
    </div>

    <div  class="controle">
        <a href="{{url('/')}}">MENU</a>
    </div>

    <script>
        const buttons = document.querySelectorAll('button[type="submit"]');

        buttons.forEach(button => {
        button.addEventListener('click', (event) => {
            button.classList.add('loading');
            });
        });
    </script>

</body>
</html>