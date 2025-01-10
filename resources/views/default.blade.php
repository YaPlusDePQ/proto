<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="default.css">
    <link rel="stylesheet" href="course.css">
    <title>Cours</title>
</head>
<body>

    <div class="course-wrapper">
        {!! $course->getHTML() !!}

        <h2>Exemple</h2>
        <div class="exercice-container">
            {!! $exemple->getHTML(true) !!}
        </div>
    </div>

    <hr>

    <div class="exercice-wrapper">
        <h2>Exercice</h2>
        @foreach($exercices as $exo)
            <div class="exercice-container">
                {!! $exo->getHTML(false) !!}
            </div>
        @endforeach
    </div>

    <div  class="controle">
        <a href="{{url('/')}}">MENU</a>
        <a href="{{url('/load/'.$course->name)}}">Changer les exercices</a>
    </div>
</body>
</html>