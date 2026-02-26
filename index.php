<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SeatScout</title>
    <style>
        /* 1. RESET & BODY */
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
            font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, Helvetica, Arial, sans-serif;
        }

        body {
            background-color: #f3f4f6; /* Light Gray */
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            padding: 1rem;
        }

        /* 2. MAIN CARD STYLES */
        .card {
            background-color: white;
            padding: 2rem;
            border-radius: 0.75rem; /* Rounded corners */
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.25); /* Deep shadow */
            width: 100%;
            max-width: 28rem; /* Like max-w-md */
            text-align: center;
        }

        .title {
            font-size: 2.25rem; /* 4xl */
            font-weight: 800;
            color: #2563eb; /* Blue-600 */
            margin-bottom: 0.5rem;
        }

        .subtitle {
            color: #6b7280; /* Gray-500 */
            margin-bottom: 1.5rem;
        }

        /* 3. FORM ELEMENTS */
        input[type="text"] {
            width: 100%;
            padding: 1rem;
            border: 2px solid #e5e7eb;
            border-radius: 0.5rem;
            font-size: 1.125rem;
            outline: none;
            transition: border-color 0.3s ease;
        }

        input[type="text"]:focus {
            border-color: #3b82f6; /* Blue-500 */
        }

        .btn-search {
            margin-top: 1rem;
            width: 100%;
            background-color: #2563eb;
            color: white;
            font-weight: 700;
            padding: 0.75rem;
            border: none;
            border-radius: 0.5rem;
            cursor: pointer;
            transition: background-color 0.3s ease;
            font-size: 1rem;
        }

        .btn-search:hover {
            background-color: #1d4ed8; /* Darker Blue */
        }

        /* 4. RESULT CARD STYLES */
        .result-card {
            margin-top: 1.5rem;
            background-color: white;
            padding: 1.5rem;
            border-radius: 0.75rem;
            box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1);
            width: 100%;
            max-width: 28rem;
            border-left: 8px solid #2563eb; /* Blue accent border */
        }

        .reg-display {
            font-size: 1.875rem; /* 3xl */
            font-weight: 800;
            color: #1f2937; /* Gray-800 */
            margin-bottom: 1rem;
            letter-spacing: 0.05em;
        }

        /* Grid layout for the two boxes */
        .info-grid {
            display: grid;
            grid-template-columns: 1fr 1fr; /* Two equal columns */
            gap: 1rem;
        }

        .info-box {
            background-color: #eff6ff; /* Blue-50 */
            padding: 1rem;
            border-radius: 0.5rem;
            border: 1px solid #dbeafe; /* Blue-100 */
        }

        .label {
            font-size: 0.75rem;
            color: #3b82f6;
            text-transform: uppercase;
            font-weight: 700;
            letter-spacing: 0.05em;
        }

        .value {
            font-size: 1.25rem; /* xl */
            font-weight: 700;
            color: #1f2937;
            margin-top: 0.25rem;
        }

        .footer-text {
            margin-top: 1rem;
            text-align: center;
            font-size: 0.75rem;
            color: #9ca3af; /* Gray-400 */
        }

        /* 5. UTILITY CLASSES */
        .hidden {
            display: none !important;
        }

        .error-msg {
            margin-top: 1.5rem;
            color: #ef4444; /* Red-500 */
            background-color: #fee2e2; /* Red-100 */
            padding: 0.75rem;
            border-radius: 0.375rem;
            font-weight: 700;
            text-align: center;
        }
    </style>
</head>
<body>

    <div class="card">
        <h1 class="title">SeatScout</h1>
        <p class="subtitle">Find your exam hall instantly.</p>
        
        <input type="text" id="regInput" placeholder="Enter Register Number">
        
        <button onclick="findSeat()" class="btn-search">
            Find My Seat
        </button>
    </div>

    <div id="resultCard" class="result-card hidden">
        <h2 id="regDisplay" class="reg-display">91001234</h2>
        
        <div class="info-grid">
            <div class="info-box">
                <p class="label">Exam Hall</p>
                <p id="hallDisplay" class="value">Room 304</p>
            </div>
            
            <div class="info-box">
                <p class="label">Seating</p>
                <p id="seatDisplay" class="value">Block A / Seat 5</p>
            </div>
        </div>
        
        <div class="footer-text">
            <p>Please verify your Hall Ticket matches this Reg No.</p>
        </div>
    </div>

    <div id="errorMsg" class="error-msg hidden"></div>

    <script>
        async function findSeat() {
            let reg = document.getElementById('regInput').value;
            let resultCard = document.getElementById('resultCard');
            let errorMsg = document.getElementById('errorMsg');

            if(!reg) return; 

            // Ask the backend
            // Make sure search.php is in the same folder!
            let response = await fetch('search.php?reg_no=' + reg);
            let data = await response.json();

            if (data.status === "found") {
                document.getElementById('regDisplay').innerText = data.data.reg_no; 
                document.getElementById('hallDisplay').innerText = data.data.hall_no;
                document.getElementById('seatDisplay').innerText = "Block " + data.data.block_no + " / Seat " + data.data.seat_no;
                
                resultCard.classList.remove('hidden');
                errorMsg.classList.add('hidden');
            } else {
                resultCard.classList.add('hidden');
                errorMsg.innerText = "❌ Student not found. Check Register No.";
                errorMsg.classList.remove('hidden');
            }
        }
    </script>
</body>
</html>