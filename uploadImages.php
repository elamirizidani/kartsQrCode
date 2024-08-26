<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Drag and Drop Image/Video Upload</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <style>
    .dropzone {
        width: 100%;
        min-height: 200px;
        border: 2px dashed #007bff;
        border-radius: 5px;
        background: #f8f9fa;
        text-align: center;
        padding: 20px;
        margin: 20px 0;
    }

    .dropzone.dragover {
        background: #e9ecef;
    }

    .preview img,
    .preview video {
        max-width: 100px;
        margin: 10px;
    }
    </style>
</head>

<body>
    <div class="container mt-5">
        <h2 class="text-center">Drag and Drop Image/Video Upload</h2>
        <form action="upload.php" method="POST" enctype="multipart/form-data" id="uploadForm">
            <div class="dropzone" id="dropzone">
                <p>Drag & Drop your images/videos here or click to select files</p>
                <input type="file" name="files[]" id="fileInput" multiple accept="image/*,video/*"
                    style="display: none;">
            </div>
            <div class="preview" id="preview"></div>
            <button type="submit" class="btn btn-primary btn-block">Upload Files</button>
        </form>
    </div>

    <script>
    const dropzone = document.getElementById('dropzone');
    const fileInput = document.getElementById('fileInput');
    const preview = document.getElementById('preview');

    dropzone.addEventListener('click', () => {
        fileInput.click();
    });

    dropzone.addEventListener('dragover', (e) => {
        e.preventDefault();
        dropzone.classList.add('dragover');
    });

    dropzone.addEventListener('dragleave', () => {
        dropzone.classList.remove('dragover');
    });

    dropzone.addEventListener('drop', (e) => {
        e.preventDefault();
        dropzone.classList.remove('dragover');
        const files = e.dataTransfer.files;
        handleFiles(files);
    });

    fileInput.addEventListener('change', (e) => {
        const files = e.target.files;
        handleFiles(files);
    });

    function handleFiles(files) {
        preview.innerHTML = '';
        for (let i = 0; i < files.length; i++) {
            const file = files[i];
            const fileType = file.type;

            if (fileType.startsWith('image/')) {
                const img = document.createElement('img');
                img.src = URL.createObjectURL(file);
                img.onload = () => URL.revokeObjectURL(img.src); // Release memory
                preview.appendChild(img);
            } else if (fileType.startsWith('video/')) {
                const video = document.createElement('video');
                video.src = URL.createObjectURL(file);
                video.controls = true;
                video.onload = () => URL.revokeObjectURL(video.src); // Release memory
                preview.appendChild(video);
            } else {
                console.log('File type not supported for preview:', fileType);
            }
        }
        fileInput.files = files;
    }
    </script>
</body>

</html>