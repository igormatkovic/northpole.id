<?php
/**
 * Create this file as: index.php (replace your existing one)
 *
 * This handles routing for Laravel Valet locally
 * and works with .htaccess on production
 */

// Get the request URI
$request_uri = $_SERVER['REQUEST_URI'];
$script_name = $_SERVER['SCRIPT_NAME'];

// Remove query string
$request_uri = strtok($request_uri, '?');

// Remove trailing slash
$request_uri = rtrim($request_uri, '/');

// Check if this is a record request
if (preg_match('#^/record/([A-Za-z0-9\-]+)$#', $request_uri, $matches)) {
    // Extract the license ID and include show.php
    $_GET['id'] = $matches[1];
    require_once 'show.php';
    exit;
}

// If not a record route, show the search page
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>North Pole DLR - License Search</title>
    <link rel="icon" href="/favicon.png"/>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Courier New', monospace;
            background: linear-gradient(135deg, #2c5f7c 0%, #1a3a4f 100%);
            min-height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 20px;
            position: relative;
            overflow-x: hidden;
        }

        .snowflake {
            position: absolute;
            top: -10px;
            color: rgba(255, 255, 255, 0.6);
            font-size: 1em;
            opacity: 0.6;
            animation: fall linear infinite;
            user-select: none;
            pointer-events: none;
        }

        @keyframes fall {
            to {
                transform: translateY(100vh) rotate(360deg);
            }
        }

        .container {
            background: #f5f5dc;
            border: 8px solid #8b4513;
            border-radius: 5px;
            box-shadow: 0 10px 40px rgba(0, 0, 0, 0.5), inset 0 0 100px rgba(139, 69, 19, 0.1);
            max-width: 650px;
            width: 100%;
            padding: 40px;
            position: relative;
            z-index: 1;
        }

        .container::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background:
                    repeating-linear-gradient(
                            0deg,
                            transparent,
                            transparent 2px,
                            rgba(139, 69, 19, 0.03) 2px,
                            rgba(139, 69, 19, 0.03) 4px
                    );
            pointer-events: none;
            border-radius: 5px;
        }

        .header {
            text-align: center;
            margin-bottom: 30px;
            padding-bottom: 20px;
            border-bottom: 4px double #8b0000;
        }

        .header h1 {
            color: #8b0000;
            font-size: 2.5em;
            font-weight: bold;
            margin-bottom: 5px;
            text-transform: uppercase;
            letter-spacing: 3px;
            text-shadow: 2px 2px 0px rgba(0, 0, 0, 0.1);
            font-family: 'Georgia', serif;
        }

        .header h2 {
            color: #2c5f7c;
            font-size: 1em;
            font-weight: normal;
            letter-spacing: 2px;
            text-transform: uppercase;
            margin-top: 8px;
        }

        .search-box {
            background: #fff8dc;
            border: 3px double #8b0000;
            padding: 30px;
            margin: 30px 0;
            border-radius: 5px;
        }

        .search-box h3 {
            color: #8b0000;
            text-align: center;
            font-size: 1.3em;
            margin-bottom: 20px;
            text-transform: uppercase;
            letter-spacing: 2px;
            font-family: 'Georgia', serif;
        }

        .search-input-container {
            position: relative;
        }

        .search-input {
            width: 100%;
            padding: 15px;
            font-size: 1.1em;
            font-family: 'Courier New', monospace;
            border: 3px solid #8b4513;
            background: #fff;
            color: #2c1810;
            border-radius: 3px;
            box-shadow: inset 0 2px 5px rgba(0, 0, 0, 0.1);
        }

        .search-input:focus {
            outline: none;
            border-color: #8b0000;
            box-shadow: inset 0 2px 5px rgba(0, 0, 0, 0.1), 0 0 10px rgba(139, 0, 0, 0.2);
        }

        .autocomplete-items {
            position: absolute;
            border: 3px solid #8b4513;
            border-top: none;
            z-index: 99;
            top: 100%;
            left: 0;
            right: 0;
            background: #fff;
            max-height: 300px;
            overflow-y: auto;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.3);
        }

        .autocomplete-items div {
            padding: 12px;
            cursor: pointer;
            background-color: #fff;
            border-bottom: 1px solid #d4a574;
            font-family: 'Courier New', monospace;
            color: #2c1810;
        }

        .autocomplete-items div:hover {
            background-color: #fff8dc;
        }

        .autocomplete-active {
            background-color: #e8d4b8 !important;
        }

        .license-info {
            font-size: 0.9em;
            color: #666;
            margin-top: 3px;
        }

        .info-box {
            background: #fff;
            border: 2px solid #8b4513;
            padding: 20px;
            margin: 20px 0;
            text-align: center;
            font-family: 'Georgia', serif;
        }

        .info-box p {
            color: #4a2511;
            line-height: 1.8;
            margin: 8px 0;
        }

        .official-seal {
            text-align: center;
            margin: 30px 0;
            font-family: 'Georgia', serif;
        }

        .seal-circle {
            display: inline-block;
            width: 100px;
            height: 100px;
            border: 5px solid #8b0000;
            border-radius: 50%;
            background: radial-gradient(circle, #ffd700 0%, #daa520 100%);
            display: flex;
            align-items: center;
            justify-content: center;
            flex-direction: column;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.3);
        }

        .seal-star {
            font-size: 1.8em;
            color: #8b0000;
        }

        .seal-text {
            font-size: 0.6em;
            color: #8b0000;
            font-weight: bold;
            text-align: center;
            line-height: 1.2;
        }

        .footer {
            text-align: center;
            margin-top: 25px;
            padding-top: 15px;
            border-top: 3px double #8b0000;
            color: #4a2511;
            font-size: 0.85em;
            font-family: 'Georgia', serif;
        }

        .footer p {
            margin: 8px 0;
            letter-spacing: 1px;
        }

        .corner-ornament {
            position: absolute;
            font-size: 2em;
            color: #8b0000;
            opacity: 0.3;
        }

        .corner-ornament.top-left {
            top: 10px;
            left: 10px;
        }

        .corner-ornament.top-right {
            top: 10px;
            right: 10px;
        }

        .corner-ornament.bottom-left {
            bottom: 10px;
            left: 10px;
        }

        .corner-ornament.bottom-right {
            bottom: 10px;
            right: 10px;
        }
    </style>
</head>
<body>
<div class="container">
    <div class="corner-ornament top-left">❄</div>
    <div class="corner-ornament top-right">❄</div>
    <div class="corner-ornament bottom-left">❄</div>
    <div class="corner-ornament bottom-right">❄</div>

    <div class="header">
        <h1>NORTH POLE</h1>
        <h2>Driver's License Registry</h2>
        <h2>License Search System</h2>
    </div>

    <div class="official-seal">
        <div class="seal-circle">
            <div class="seal-star">★</div>
            <div class="seal-text">OFFICIAL<br>NORTH POLE<br>REGISTRY</div>
        </div>
    </div>

    <div class="search-box">
        <h3>License Lookup</h3>
        <form id="searchForm" autocomplete="off">
            <div class="search-input-container">
                <input
                    type="text"
                    id="licenseSearch"
                    class="search-input"
                    placeholder="Enter license number or name..."
                    autocomplete="off"
                >
                <div id="autocomplete-list" class="autocomplete-items"></div>
            </div>
        </form>
    </div>

    <div class="info-box">
        <p><strong>AUTHORIZED SEARCH PORTAL</strong></p>
        <p>Enter a license number or cardholder name to verify credentials</p>
        <p>All searches are logged for security purposes</p>
    </div>

    <div class="footer">
        <p>═══════════════════════════════</p>
        <p>NORTH POLE DEPARTMENT OF MAGICAL TRANSPORTATION</p>
        <p>Issuer Contact: 123 Elf Road, North Pole, 88888</p>
        <p>Emergency Line: 1-800-SANTACLAUS</p>
        <p>═══════════════════════════════</p>
    </div>
</div>

<script>
    // License database for autocomplete
    const licenses = [
        {
            id: 'NP-0000001',
            name: 'Saint Nicholas',
            alias: 'Santa Claus',
            classification: 'Sleigh Master A'
        },
        {
            id: 'NP-0000002',
            name: 'Jessica Claus',
            alias: 'Mrs. Claus',
            classification: 'Cookie Master A'
        },
        {
            id: 'NP-0000003',
            name: 'Jingleberry Sparkletoes',
            alias: 'Chief Elf',
            classification: 'Elf Supervisor A'
        }
    ];

    const input = document.getElementById('licenseSearch');
    const autocompleteList = document.getElementById('autocomplete-list');
    let currentFocus = -1;

    input.addEventListener('input', function() {
        const val = this.value.trim();
        closeAllLists();

        if (!val) {
            return false;
        }

        currentFocus = -1;

        const matches = licenses.filter(license => {
            const searchStr = val.toLowerCase();
            return license.id.toLowerCase().includes(searchStr) ||
                license.name.toLowerCase().includes(searchStr) ||
                license.alias.toLowerCase().includes(searchStr);
        });

        if (matches.length === 0) {
            return false;
        }

        matches.forEach(license => {
            const item = document.createElement('div');
            item.innerHTML = `
                    <strong>${license.id}</strong> - ${license.name} (${license.alias})
                    <div class="license-info">${license.classification}</div>
                `;
            item.addEventListener('click', function() {
                window.location.href = '/record/' + license.id;
            });
            autocompleteList.appendChild(item);
        });
    });

    input.addEventListener('keydown', function(e) {
        let items = autocompleteList.getElementsByTagName('div');

        if (e.keyCode === 40) { // Down arrow
            currentFocus++;
            addActive(items);
            e.preventDefault();
        } else if (e.keyCode === 38) { // Up arrow
            currentFocus--;
            addActive(items);
            e.preventDefault();
        } else if (e.keyCode === 13) { // Enter
            e.preventDefault();
            if (currentFocus > -1 && items[currentFocus]) {
                items[currentFocus].click();
            } else {
                // Try exact match
                const val = this.value.trim().toUpperCase();
                const exactMatch = licenses.find(l => l.id === val);
                if (exactMatch) {
                    window.location.href = '/record/' + exactMatch.id;
                } else {
                    window.location.href = '/record/' + val;
                }
            }
        }
    });

    function addActive(items) {
        if (!items) return false;
        removeActive(items);
        if (currentFocus >= items.length) currentFocus = 0;
        if (currentFocus < 0) currentFocus = (items.length - 1);
        items[currentFocus].classList.add('autocomplete-active');
    }

    function removeActive(items) {
        for (let i = 0; i < items.length; i++) {
            items[i].classList.remove('autocomplete-active');
        }
    }

    function closeAllLists() {
        autocompleteList.innerHTML = '';
        currentFocus = -1;
    }

    document.addEventListener('click', function(e) {
        if (e.target !== input) {
            closeAllLists();
        }
    });

    // Create falling snowflakes
    function createSnowflake() {
        const snowflake = document.createElement('div');
        snowflake.classList.add('snowflake');
        snowflake.innerHTML = '❄';
        snowflake.style.left = Math.random() * 100 + '%';
        snowflake.style.animationDuration = Math.random() * 3 + 6 + 's';
        snowflake.style.opacity = Math.random() * 0.5 + 0.3;
        snowflake.style.fontSize = Math.random() * 0.8 + 0.5 + 'em';
        document.body.appendChild(snowflake);

        setTimeout(() => {
            snowflake.remove();
        }, 9000);
    }

    setInterval(createSnowflake, 300);
</script>
</body>
</html>