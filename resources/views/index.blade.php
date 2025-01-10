<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Selection des cours</title>
</head>
<style>
/* Global styles */
body {
    font-family: Arial, sans-serif;
    background-color: #f0f8ff;
    color: #333;
    margin: 0;
    padding: 0;
    display: flex;
    flex-direction:column;

    gap: 5px;
    justify-content: center;
    align-items: center;
    height: 100vh;
}

/* Link styles */
a {
    font-size: 1em;
    color: #ffffff;
    text-decoration: none;
    background-color: #007BFF;
    padding: 10px 20px;
    border-radius: 8px;
    transition: background-color 0.3s, transform 0.2s;
}

a:hover {
    background-color: #0056b3;
    transform: scale(1.05);
}

a:active {
    background-color: #003d80;
}

/* Centering content */
body > a {
    text-align: center;
}
</style>
<body>
    <div></div>
    <h1>Selection du cours</h1>
    <a href="{{url('/load/py')}}">Pythagore</a>
    <a href="{{url('/load/th')}}">Thales</a>

</body>

<script>

</script>
</html>