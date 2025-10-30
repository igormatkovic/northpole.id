<?php
// Database of North Pole license holders
$licenses = [
    'NP-0000001' => [
        'name' => 'Saint Nicholas',
        'alias' => 'Santa Claus',
        'classification' => 'Sleigh Master A',
        'dob' => 'March 15, 270 AD',
        'address' => '123 Elf Road, North Pole, 88888',
        'issue_date' => '12/01/2024',
        'expiration_date' => '12/31/2034',
        'status' => 'ACTIVE - IN GOOD STANDING',
        'endorsements' => [
            'Chimney Access Authorization',
            'Night Vision Flight Certified',
            'Reindeer Team Command (8 + 1 Rudolph)',
            'Must Maintain Magic at All Times',
            'High Cookie Tolerance (Medical Alert)'
        ],
        'emergency_contact' => 'Mrs. Claus - 1-800-SANTACLAUS'
    ],
    'NP-0000002' => [
        'name' => 'Jessica Claus',
        'alias' => 'Mrs. Claus',
        'classification' => 'Cookie Master A',
        'dob' => 'December 25, 275 AD',
        'address' => '123 Elf Road, North Pole, 88888',
        'issue_date' => '12/01/2024',
        'expiration_date' => '12/31/2034',
        'status' => 'ACTIVE - IN GOOD STANDING',
        'endorsements' => [
            'Kitchen Access Authorization',
            'Cookie Baking Certified',
            'Toy Quality Control Clearance',
            'Elf Management Certification',
            'Advanced Knitting License'
        ],
        'emergency_contact' => 'Santa Claus - 1-800-SANTACLAUS'
    ],
    'NP-0000003' => [
        'name' => 'Jingleberry Sparkletoes',
        'alias' => 'Chief Elf',
        'classification' => 'Elf Supervisor A',
        'dob' => 'January 1, 1650 AD',
        'address' => '456 Workshop Lane, North Pole, 88888',
        'issue_date' => '12/01/2024',
        'expiration_date' => '12/31/2034',
        'status' => 'ACTIVE - IN GOOD STANDING',
        'endorsements' => [
            'Toy Workshop Authorization',
            'Heavy Machinery Operation',
            'Quality Control Certified',
            'Wrapping Speed Endorsement',
            'Naughty/Nice List Access'
        ],
        'emergency_contact' => 'Santa Claus - 1-800-SANTACLAUS'
    ]
];

// Get license ID from URL parameter
$license_id = isset($_GET['id']) ? strtoupper(trim($_GET['id'])) : '';

// Check if license exists
$license = isset($licenses[$license_id]) ? $licenses[$license_id] : null;
$is_valid = $license !== null;

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>North Pole DLR - License Verification</title>
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
            padding: 30px;
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
            margin-bottom: 25px;
            padding-bottom: 15px;
            border-bottom: 4px double #8b0000;
            position: relative;
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

        .license-number {
            background: #fff;
            border: 3px solid #8b0000;
            padding: 15px;
            text-align: center;
            font-size: 1.8em;
            font-weight: bold;
            color: #8b0000;
            letter-spacing: 3px;
            margin: 20px 0;
            box-shadow: inset 0 2px 5px rgba(0, 0, 0, 0.2);
        }

        .stamp-container {
            position: relative;
            text-align: center;
            margin: 25px 0;
        }

        .stamp {
            display: inline-block;
            border: 4px solid #8b0000;
            border-radius: 50%;
            padding: 20px;
            transform: rotate(-5deg);
            background: radial-gradient(circle, rgba(139, 0, 0, 0.1) 0%, transparent 70%);
        }

        .stamp.invalid {
            border-color: #666;
            transform: rotate(5deg);
        }

        .stamp.invalid .stamp-inner {
            border-color: #666;
        }

        .stamp.invalid .stamp-text,
        .stamp.invalid .stamp-subtext {
            color: #666;
        }

        .stamp-inner {
            border: 2px solid #8b0000;
            border-radius: 50%;
            padding: 15px 25px;
            text-align: center;
        }

        .stamp-text {
            color: #8b0000;
            font-weight: bold;
            font-size: 1.2em;
            letter-spacing: 1px;
        }

        .stamp-subtext {
            color: #8b0000;
            font-size: 0.9em;
            margin-top: 5px;
        }

        .info-table {
            width: 100%;
            border-collapse: collapse;
            margin: 20px 0;
            background: #fff;
            border: 2px solid #8b4513;
        }

        .info-table td {
            padding: 12px;
            border: 1px solid #d4a574;
            font-family: 'Courier New', monospace;
        }

        .info-table td:first-child {
            background: #e8d4b8;
            font-weight: bold;
            color: #4a2511;
            width: 40%;
            text-transform: uppercase;
            font-size: 0.85em;
            letter-spacing: 1px;
        }

        .info-table td:last-child {
            color: #2c1810;
            font-size: 1em;
        }

        .classification-box {
            background: #fff8dc;
            border: 3px double #8b0000;
            padding: 20px;
            margin: 20px 0;
            text-align: center;
        }

        .classification-box h3 {
            color: #8b0000;
            font-size: 1.3em;
            margin-bottom: 15px;
            text-transform: uppercase;
            letter-spacing: 2px;
            font-family: 'Georgia', serif;
        }

        .classification-box ul {
            list-style: none;
            padding: 0;
            text-align: left;
            columns: 1;
        }

        .classification-box li {
            padding: 8px;
            color: #4a2511;
            font-size: 0.95em;
            border-bottom: 1px dotted #d4a574;
        }

        .classification-box li:last-child {
            border-bottom: none;
        }

        .classification-box li:before {
            content: "★ ";
            color: #ffd700;
            margin-right: 8px;
        }

        .official-seal {
            text-align: center;
            margin: 25px 0;
            font-family: 'Georgia', serif;
        }

        .seal-circle {
            display: inline-block;
            width: 120px;
            height: 120px;
            border: 5px solid #8b0000;
            border-radius: 50%;
            position: relative;
            background: radial-gradient(circle, #ffd700 0%, #daa520 100%);
            display: flex;
            align-items: center;
            justify-content: center;
            flex-direction: column;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.3);
        }

        .seal-star {
            font-size: 2em;
            color: #8b0000;
        }

        .seal-text {
            font-size: 0.7em;
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

        .timestamp {
            text-align: center;
            color: #8b4513;
            font-size: 0.8em;
            margin-top: 15px;
            font-style: italic;
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

        .verification-date {
            background: #fff;
            border: 2px solid #8b4513;
            padding: 10px;
            margin: 15px 0;
            text-align: center;
            font-weight: bold;
            color: #8b0000;
            letter-spacing: 1px;
        }

        .error-message {
            background: #ffebee;
            border: 3px solid #c62828;
            padding: 20px;
            margin: 20px 0;
            text-align: center;
            color: #c62828;
            font-weight: bold;
            font-size: 1.1em;
        }

        .error-details {
            margin-top: 10px;
            font-size: 0.9em;
            color: #666;
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
        <h2>Official Verification System</h2>
    </div>

    <?php if ($is_valid): ?>
        <div class="stamp-container">
            <div class="stamp">
                <div class="stamp-inner">
                    <div class="stamp-text">VERIFIED</div>
                    <div class="stamp-text">AUTHENTIC</div>
                    <div class="stamp-subtext">Official Document</div>
                </div>
            </div>
        </div>

        <div class="license-number"><?php echo htmlspecialchars($license_id); ?></div>

        <table class="info-table">
            <tr>
                <td>License Holder:</td>
                <td><?php echo strtoupper(htmlspecialchars($license['name'])); ?> (<?php echo htmlspecialchars($license['alias']); ?>)</td>
            </tr>
            <tr>
                <td>Classification:</td>
                <td><?php echo htmlspecialchars($license['classification']); ?></td>
            </tr>
            <tr>
                <td>Date of Birth:</td>
                <td><?php echo htmlspecialchars($license['dob']); ?></td>
            </tr>
            <tr>
                <td>Address:</td>
                <td><?php echo htmlspecialchars($license['address']); ?></td>
            </tr>
            <tr>
                <td>Issue Date:</td>
                <td><?php echo htmlspecialchars($license['issue_date']); ?></td>
            </tr>
            <tr>
                <td>Expiration Date:</td>
                <td><?php echo htmlspecialchars($license['expiration_date']); ?></td>
            </tr>
            <tr>
                <td>Status:</td>
                <td><?php echo htmlspecialchars($license['status']); ?></td>
            </tr>
        </table>

        <div class="classification-box">
            <h3>Endorsements & Restrictions</h3>
            <ul>
                <?php foreach ($license['endorsements'] as $endorsement): ?>
                    <li><?php echo htmlspecialchars($endorsement); ?></li>
                <?php endforeach; ?>
            </ul>
        </div>

        <div class="verification-date">
            VERIFIED: <?php echo date('m/d/Y h:i A'); ?>
        </div>

        <div class="official-seal">
            <div class="seal-circle">
                <div class="seal-star">★</div>
                <div class="seal-text">OFFICIAL<br>NORTH POLE<br>REGISTRY</div>
            </div>
        </div>

        <div class="footer">
            <p>═══════════════════════════════</p>
            <p>NORTH POLE DEPARTMENT OF MAGICAL TRANSPORTATION</p>
            <p>This license has been verified against the Master Registry</p>
            <p>Issuer Contact: 123 Elf Road, North Pole, 88888</p>
            <p>Emergency Contact: <?php echo htmlspecialchars($license['emergency_contact']); ?></p>
            <p>═══════════════════════════════</p>
        </div>

    <?php else: ?>
        <div class="stamp-container">
            <div class="stamp invalid">
                <div class="stamp-inner">
                    <div class="stamp-text">INVALID</div>
                    <div class="stamp-text">NOT FOUND</div>
                    <div class="stamp-subtext">Database Error</div>
                </div>
            </div>
        </div>

        <div class="error-message">
            LICENSE NOT FOUND IN DATABASE
            <div class="error-details">
                <?php if (empty($license_id)): ?>
                    No license ID provided. Please scan a valid North Pole DLR QR code.
                <?php else: ?>
                    License ID "<?php echo htmlspecialchars($license_id); ?>" is not registered in the North Pole system.
                <?php endif; ?>
            </div>
        </div>

        <div class="footer">
            <p>═══════════════════════════════</p>
            <p>NORTH POLE DEPARTMENT OF MAGICAL TRANSPORTATION</p>
            <p>If you believe this is an error, please contact:</p>
            <p>123 Elf Road, North Pole, 88888</p>
            <p>1-800-SANTACLAUS</p>
            <p>═══════════════════════════════</p>
        </div>
    <?php endif; ?>

    <div class="timestamp">
        Document retrieved from North Pole Database on <?php echo date('F d, Y \a\t h:i:s A'); ?>
    </div>
</div>

<script>
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