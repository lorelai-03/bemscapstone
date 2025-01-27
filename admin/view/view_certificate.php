<?php
require 'vendor/autoload.php';
use PhpOffice\PhpWord\IOFactory;

$id = $_GET['id'];
$conn = new mysqli('localhost', 'root', '', 'db_student');
$stmt = $conn->prepare("SELECT certificate_name, file_path FROM certificates WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$stmt->bind_result($certificateName, $filePath);
$stmt->fetch();
$stmt->close();
$conn->close();

// Load the .docx file and convert it to HTML
$phpWord = IOFactory::load($filePath);
$htmlWriter = IOFactory::createWriter($phpWord, 'HTML');
ob_start();
$htmlWriter->save("php://output");
$htmlContent = ob_get_clean();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View and Edit Certificate</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.tiny.cloud/1/no-api-key/tinymce/5/tinymce.min.js"></script>
</head>
<body>
<div class="container mt-5">
    <h3>Certificate: <?php echo htmlspecialchars($certificateName); ?></h3>

    <div class="card p-3 mt-3">
        <!-- TinyMCE Editor for Editing -->
        <textarea id="editor" name="certificate_content"><?php echo htmlspecialchars($htmlContent); ?></textarea>
    </div>
    <button id="saveBtn" class="btn btn-success mt-3">Save Changes</button>
</div>

<script>
    // Initialize TinyMCE with full features for rich text editing
    tinymce.init({
        selector: '#editor',
        menubar: false,
        plugins: ['link', 'image', 'table', 'code'],
        toolbar: 'undo redo | formatselect | bold italic | alignleft aligncenter alignright | link image | code',
        content_css: 'https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css',  // Use bootstrap styling for better consistency
        setup: function(editor) {
            // Automatically adjust editor's height
            editor.on('init', function() {
                editor.setContent('<?php echo $htmlContent; ?>');
            });
        }
    });

    // Handle save button click
    document.getElementById('saveBtn').addEventListener('click', function() {
        const content = tinymce.get('editor').getContent();
        const xhr = new XMLHttpRequest();
        xhr.open('POST', 'save_certificate.php', true);
        xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
        xhr.onload = function() {
            if (xhr.status === 200) {
                alert('Certificate saved successfully!');
            } else {
                alert('Error saving certificate.');
            }
        };
        xhr.send('certificate_content=' + encodeURIComponent(content) + '&file_path=<?php echo $filePath; ?>');
    });
</script>

</body>
</html>
