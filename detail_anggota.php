<?php
$host = "localhost";
$user = "root";
$pass = "";
$db = "anggota";

$conn = new mysqli($host, $user, $pass, $db);

if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

if (isset($_GET["id"])) {
    $id = $_GET["id"];
    
    // Gunakan prepared statement biar lebih aman
    $stmt = $conn->prepare("SELECT * FROM anggota_koperasi WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        ?>
        <!DOCTYPE html>
        <html lang="id">
        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title>Profil Anggota</title>
            <style>
                body { font-family: Arial, sans-serif; text-align: center; background-color: #f4f4f4; }
                .container { max-width: 400px; margin: 50px auto; background: white; padding: 20px; border-radius: 10px; box-shadow: 0 0 10px rgba(0,0,0,0.1); }
                img { border-radius: 50%; width: 100px; height: 100px; object-fit: cover; }
                h2 { color: #2c3e50; }
                p { color: #34495e; }
            </style>
        </head>
        <body>
            <div class="container">
                <img src="<?= $row["foto"] ?>" alt="<?= $row["nama"] ?>">
                <h2><?= htmlspecialchars($row["nama"]) ?></h2>
                <p><strong>Jabatan:</strong> <?= htmlspecialchars($row["jabatan"]) ?></p>
                <p><strong>Email:</strong> <?= htmlspecialchars($row["email"]) ?></p>
            </div>
        </body>
        </html>
        <?php
    } else {
        echo "Anggota tidak ditemukan.";
    }

    $stmt->close();
} else {
    echo "ID tidak diberikan.";
}

$conn->close();
?>
