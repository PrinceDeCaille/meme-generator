<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Générateur de Mèmes</title>
    <style>
        canvas { border: 1px solid black; max-width: 100%; }
        input, button { margin-top: 10px; }
    </style>
</head>
<body>
    <h1>🎉 Générateur de Mèmes</h1>

    <form id="uploadForm" enctype="multipart/form-data">
        <input type="file" name="image" id="imageInput" required>
        <button type="submit">Uploader</button>
    </form>
    <a href="{{ route('memes.download', ['filename' => $meme->filename]) }}" class="btn btn-primary">📥 Télécharger</a>


    <br>

    <input type="text" id="topText" placeholder="Texte en haut"><br>
    <input type="text" id="bottomText" placeholder="Texte en bas"><br>
    <canvas id="memeCanvas" width="500" height="500"></canvas><br>
    <button onclick="downloadMeme()">Télécharger le mème</button>

    <script>
        let canvas = document.getElementById('memeCanvas');
        let ctx = canvas.getContext('2d');
        let image = new Image();

        document.getElementById('uploadForm').addEventListener('submit', function (e) {
            e.preventDefault();

            let formData = new FormData(this);
            fetch('/upload', {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: formData
            })
            .then(res => res.json())
            .then(data => {
                image.src = data.url;
                image.onload = drawMeme;
            });
        });

        document.getElementById('topText').addEventListener('input', drawMeme);
        document.getElementById('bottomText').addEventListener('input', drawMeme);

        function drawMeme() {
            ctx.clearRect(0, 0, canvas.width, canvas.height);
            ctx.drawImage(image, 0, 0, canvas.width, canvas.height);
            ctx.font = 'bold 30px Impact';
            ctx.fillStyle = 'white';
            ctx.strokeStyle = 'black';
            ctx.textAlign = 'center';

            ctx.fillText(document.getElementById('topText').value, canvas.width / 2, 40);
            ctx.strokeText(document.getElementById('topText').value, canvas.width / 2, 40);

            ctx.fillText(document.getElementById('bottomText').value, canvas.width / 2, canvas.height - 20);
            ctx.strokeText(document.getElementById('bottomText').value, canvas.width / 2, canvas.height - 20);
        }

        function downloadMeme() {
            const link = document.createElement('a');
            link.download = 'meme.png';
            link.href = canvas.toDataURL();
            link.click();
        }
    </script>
</body>
</html>
