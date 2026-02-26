<?php
include 'db.php';
$message = "";

// --- LOGIC 1: CSV Upload ---
if (isset($_POST['upload_csv'])) {
    if ($_FILES['csv_file']['name']) {
        $filename = explode(".", $_FILES['csv_file']['name']);
        if (end($filename) == "csv") {
            $handle = fopen($_FILES['csv_file']['tmp_name'], "r");
            fgetcsv($handle); // Skip Header
            
            while ($data = fgetcsv($handle)) {
                // New CSV Format: RegNo, Hall, Block, Seat
                $reg   = $data[0];
                $hall  = $data[1];
                $block = $data[2];
                $seat  = $data[3];

                $stmt = $conn->prepare("INSERT INTO seats (reg_no, hall_no, block_no, seat_no) VALUES (?, ?, ?, ?) ON DUPLICATE KEY UPDATE hall_no=?, block_no=?, seat_no=?");
                $stmt->bind_param("sssssss", $reg, $hall, $block, $seat, $hall, $block, $seat);
                $stmt->execute();
            }
            fclose($handle);
            $message = "✅ Bulk Upload Successful!";
        } else {
            $message = "❌ CSV files only.";
        }
    }
}

// --- LOGIC 2: Manual Entry (Emergency) ---
if (isset($_POST['manual_entry'])) {
    $reg   = $_POST['reg_no'];
    $hall  = $_POST['hall_no'];
    $block = $_POST['block_no'];
    $seat  = $_POST['seat_no'];

    if($reg && $hall) {
        $stmt = $conn->prepare("INSERT INTO seats (reg_no, hall_no, block_no, seat_no) VALUES (?, ?, ?, ?) ON DUPLICATE KEY UPDATE hall_no=?, block_no=?, seat_no=?");
        $stmt->bind_param("sssssss", $reg, $hall, $block, $seat, $hall, $block, $seat);
        
        if($stmt->execute()){
            $message = "✅ Student $reg assigned to Hall $hall!";
        } else {
            $message = "❌ Error adding student.";
        }
    }
}
?>

<?php
include 'db.php';
$message = "";

// --- LOGIC 1: CSV Upload ---
if (isset($_POST['upload_csv'])) {
    if ($_FILES['csv_file']['name']) {
        $filename = explode(".", $_FILES['csv_file']['name']);
        if (end($filename) == "csv") {
            $handle = fopen($_FILES['csv_file']['tmp_name'], "r");
            fgetcsv($handle); // Skip Header
            
            while ($data = fgetcsv($handle)) {
                // New CSV Format: RegNo, Hall, Block, Seat
                $reg   = $data[0];
                $hall  = $data[1];
                $block = $data[2];
                $seat  = $data[3];

                // FIXED: 7 variables = 7 letters "sssissi"
                $stmt = $conn->prepare("INSERT INTO seats (reg_no, hall_no, block_no, seat_no) VALUES (?, ?, ?, ?) ON DUPLICATE KEY UPDATE hall_no=?, block_no=?, seat_no=?");
                $stmt->bind_param("sssssss", $reg, $hall, $block, $seat, $hall, $block, $seat);
                $stmt->execute();
            }
            fclose($handle);
            $message = "✅ Bulk Upload Successful!";
        } else {
            $message = "❌ CSV files only.";
        }
    }
}

// --- LOGIC 2: Manual Entry (Emergency) ---
if (isset($_POST['manual_entry'])) {
    $reg   = $_POST['reg_no'];
    $hall  = $_POST['hall_no'];
    $block = $_POST['block_no'];
    $seat  = $_POST['seat_no'];

    if($reg && $hall) {
        // FIXED: 7 variables = 7 letters "sssissi"
        $stmt = $conn->prepare("INSERT INTO seats (reg_no, hall_no, block_no, seat_no) VALUES (?, ?, ?, ?) ON DUPLICATE KEY UPDATE hall_no=?, block_no=?, seat_no=?");
        $stmt->bind_param("sssssss", $reg, $hall, $block, $seat, $hall, $block, $seat);
        
        if($stmt->execute()){
            $message = "✅ Student $reg assigned to Hall $hall!";
        } else {
            $message = "❌ Error adding student.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin - SeatScout</title>
    <style>
        /* 1. DARK MODE RESET */
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
            font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, Helvetica, Arial, sans-serif;
        }

        body {
            background-color: #111827; /* Gray-900 */
            color: white;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 1rem;
        }

        /* 2. ADMIN CONTAINER */
        .admin-card {
            background-color: #1f2937; /* Gray-800 */
            padding: 2rem;
            border-radius: 0.5rem;
            box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
            width: 100%;
            max-width: 32rem; /* lg */
        }

        .main-title {
            font-size: 1.875rem; /* 3xl */
            font-weight: 700;
            text-align: center;
            color: #60a5fa; /* Blue-400 */
            margin-bottom: 1.5rem;
        }

        /* 3. MESSAGE BANNER */
        .msg-box {
            margin-bottom: 1.5rem;
            padding: 0.75rem;
            background-color: #1e3a8a; /* Blue-900 */
            border: 1px solid #3b82f6; /* Blue-500 */
            border-radius: 0.25rem;
            text-align: center;
            color: #dbeafe; /* Blue-100 */
            font-weight: 600;
        }

        /* 4. SECTIONS */
        .section {
            margin-bottom: 2rem;
        }

        .section-header {
            border-bottom: 1px solid #374151; /* Gray-700 */
            padding-bottom: 2rem;
        }

        .section-title {
            font-size: 1.125rem; /* lg */
            font-weight: 600;
            margin-bottom: 1rem;
            display: flex;
            align-items: center;
        }

        .section-title.orange { color: #fb923c; } /* Orange-400 */

        .helper-text {
            margin-top: 0.5rem;
            font-size: 0.75rem;
            color: #9ca3af; /* Gray-500 */
        }

        /* 5. FORM ELEMENTS */
        .flex-form {
            display: flex;
            gap: 0.5rem;
        }

        .grid-form {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 1rem;
        }

        .col-span-2 {
            grid-column: span 2;
        }

        input[type="text"], 
        input[type="number"] {
            padding: 0.75rem;
            background-color: #374151; /* Gray-700 */
            border: 1px solid #4b5563; /* Gray-600 */
            color: white;
            border-radius: 0.25rem;
            outline: none;
            width: 100%;
        }

        input:focus {
            border-color: #f97316; /* Orange-500 */
        }

        /* 6. FILE INPUT STYLING */
        input[type="file"] {
            display: block;
            width: 100%;
            font-size: 0.875rem;
            color: #9ca3af;
        }

        input[type="file"]::file-selector-button {
            margin-right: 1rem;
            padding: 0.5rem 1rem;
            border: none;
            border-radius: 9999px;
            background-color: #2563eb; /* Blue-600 */
            color: white;
            font-weight: 600;
            cursor: pointer;
            transition: background-color 0.2s;
        }

        input[type="file"]::file-selector-button:hover {
            background-color: #1d4ed8;
        }

        /* 7. BUTTONS */
        .btn {
            padding: 0.5rem 1rem;
            border-radius: 0.25rem;
            font-weight: 700;
            cursor: pointer;
            border: none;
            color: white;
            transition: opacity 0.2s;
        }

        .btn:hover { opacity: 0.9; }

        .btn-green { background-color: #16a34a; } /* Green-600 */
        .btn-orange { 
            background-color: #ea580c; /* Orange-600 */
            width: 100%;
            padding: 0.75rem;
        }

    </style>
</head>
<body>

    <div class="admin-card">
        <h2 class="main-title">Control Panel</h2>
        
        <?php if($message): ?>
            <div class="msg-box">
                <?= $message ?>
            </div>
        <?php endif; ?>

        <div class="section section-header">
            <h3 class="section-title">📂 Bulk CSV Upload</h3>
            <form method="post" enctype="multipart/form-data" class="flex-form">
                <input type="file" name="csv_file" required>
                <button type="submit" name="upload_csv" class="btn btn-green">Upload</button>
            </form>
            <p class="helper-text">CSV Format: RegNo, Hall, Block, Seat</p>
        </div>

        <div class="section">
            <h3 class="section-title orange">🚨 Emergency Manual Entry</h3>
            <form method="post" class="grid-form">
                <input type="text" name="reg_no" placeholder="Reg No (e.g. 9100..)" required class="col-span-2">
                <input type="text" name="hall_no" placeholder="Hall (e.g. 304)" required>
                <input type="text" name="block_no" placeholder="Block (e.g. A)" required>
                <input type="number" name="seat_no" placeholder="Seat No" required class="col-span-2">
                
                <button type="submit" name="manual_entry" class="btn btn-orange col-span-2">
                    Assign Seat Immediately
                </button>
            </form>
        </div>
    </div>

</body>
</html>