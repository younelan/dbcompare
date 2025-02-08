<?php
session_start();
require_once __DIR__ . '/classes/Database.php';
require_once __DIR__ . '/classes/DBSessionManager.php';

$session = new DBSessionManager();
$credentials = $session->getCredentials();

if (!$credentials) {
    header('Location: index.php');
    exit;
}

$db = new Database($credentials['host'], $credentials['username'], $credentials['password']);
$databases = $db->getDatabases();
$selected = $session->getSelectedDatabases();
?>
<!DOCTYPE html>
<html>
<head>
    <title>Database Comparison Tool</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .table-diff { border-left: 4px solid; }
        .table-identical { border-left-color: #28a745; }
        .table-different { border-left-color: #ffc107; }
        .table-missing { border-left-color: #dc3545; }
        .status-badge {
            padding: 0.25em 0.6em;
            border-radius: 12px;
            font-size: 0.9em;
        }
        .header-section {
            background: #2c3e50;
            color: white;
            padding: 1rem 0;
            margin-bottom: 2rem;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }
    </style>
</head>
<body class="bg-light">
    <div class="header-section">
        <div class="container">
            <div class="row align-items-center">
                <div class="col">
                    <h2>DB Compare</h2>
                </div>
                <div class="col text-end">
                    <small>Connected as: <?php echo htmlspecialchars($credentials['username']); ?></small>
                </div>
            </div>
        </div>
    </div>
    <div class="container">
        <div class="row mb-4">
            <div class="col-12 mb-4">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Select Databases to Compare</h5>
                        <div class="row">
                            <div class="col-md-6">
                                <label for="db1" class="form-label">Database 1</label>
                                <select id="db1" class="form-select">
                                    <option value="">Select Database 1</option>
                                    <?php foreach ($databases as $database): ?>
                                        <option value="<?php echo htmlspecialchars($database); ?>"
                                                <?php echo ($selected && $selected['db1'] === $database) ? 'selected' : ''; ?>>
                                            <?php echo htmlspecialchars($database); ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label for="db2" class="form-label">Database 2</label>
                                <select id="db2" class="form-select">
                                    <option value="">Select Database 2</option>
                                    <?php foreach ($databases as $database): ?>
                                        <option value="<?php echo htmlspecialchars($database); ?>"
                                                <?php echo ($selected && $selected['db2'] === $database) ? 'selected' : ''; ?>>
                                            <?php echo htmlspecialchars($database); ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div id="comparison-results" class="mt-4">
            <div class="alert alert-info">Please select two databases to compare.</div>
        </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="js/comparison.js"></script>
</body>
</html>
