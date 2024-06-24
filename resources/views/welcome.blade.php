<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Загрузка файла</title>
</head>
<body>
    <form id="uploadForm" enctype="multipart/form-data">
        @csrf
        <input type="file" name="file" id="file">
        <button type="submit">Загрузить файл</button>
    </form>

    <div id="response"></div>

    <script>
        document.getElementById('uploadForm').addEventListener('submit', function(e) {
            e.preventDefault();
            
            var formData = new FormData(this);

            fetch('/import', {
                method: 'POST',
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                document.getElementById('response').innerHTML = data.message;
            })
            .catch(error => console.error('Ошибка:', error));
        });
    </script>
</body>
</html>