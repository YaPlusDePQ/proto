<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Selection des cours</title>
</head>
<style>
    .loading-overlay {
      position: fixed;
      top: 0;
      left: 0;
      width: 100%;
      height: 100%;
      background-color: rgba(0, 0, 0, 0.7);
      display: flex;
      justify-content: center;
      align-items: center;
      z-index: 1000;
      visibility: hidden;
      opacity: 0;
      transition: opacity 0.3s ease, visibility 0.3s ease;
    }

    .loading-overlay.active {
      visibility: visible;
      opacity: 1;
    }

    .spinner {
      width: 50px;
      height: 50px;
      border: 5px solid transparent;
      border-top: 5px solid #ffffff;
      border-radius: 50%;
      animation: spin 1s linear infinite;
    }

    @keyframes spin {
      0% {
        transform: rotate(0deg);
      }
      100% {
        transform: rotate(360deg);
      }
    }

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

    <div class="loading-overlay" id="loadingOverlay">
        <div class="spinner"></div>
    </div>

    <h1>Selection du cours (V1)</h1>
    <a href="{{url('/load/py')}}" onclick="showLoadingOverlay()">THÉORÈME DE PYTHAGORE ET SA RECIPROQUE</a>
    <a href="{{url('/load/th')}}" onclick="showLoadingOverlay()">THÉORÈME DE THALÈS ET SA RECIPROQUE</a>
    <a href="{{url('/load/tr')}}" onclick="showLoadingOverlay()">TRIGONOMETRIE</a>
    <a href="{{url('/load/ts')}}" onclick="showLoadingOverlay()">TRIANGLES SEMBLABLES</a>
    <a href="{{url('/load/sy')}}" onclick="showLoadingOverlay()">SYMETRIE</a>
    <a href="{{url('/load/arr')}}"  onclick="showLoadingOverlay()">AGRANDISSEMENT, REDUCTION, RETOURNEMENT</a>

    <h1>Selection de l'exercice (V2)</h1>
    <a href="{{url('V2/load/py')}}"  onclick="showLoadingOverlay()">THÉORÈME DE PYTHAGORE ET SA RECIPROQUE</a>

  </div>

  <script>
    function showLoadingOverlay() {
      const overlay = document.getElementById('loadingOverlay');
      overlay.classList.add('active');
    }

  </script>

</body>


</html>