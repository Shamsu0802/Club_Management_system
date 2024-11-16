<?php
session_start();
include 'config.php';

// Check if admin is logged in
if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'admin') {
    header("Location: index.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Admin - View Reports</title>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<style>
    .container { width: 90%; margin: 20px auto; }
    table { width: 100%; border-collapse: collapse; margin-top: 20px; }
    th, td { padding: 10px; text-align: left; border-bottom: 1px solid #ddd; }
    th { background-color: #4CAF50; color: white; }
    .chart-container { width: 50%; margin: 20px auto; }
</style>
</head>
<body>
<div class="container">
    <h2>Admin - View Reports</h2>

    <!-- Event Participation Report -->
    <h3>Event Participation Report</h3>
    <table>
        <tr>
            <th>Event ID</th>
            <th>Title</th>
            <th>Date</th>
            <th>Status</th>
            <th>Participants</th>
        </tr>
        <?php
        $sql = "SELECT e.event_id, e.title, e.date, e.status, COUNT(r.registration_id) AS participants 
                FROM events e 
                LEFT JOIN registrations r ON e.event_id = r.event_id 
                GROUP BY e.event_id";
        $result = $conn->query($sql);

        if (!$result) {
            die("Query Error: " . $conn->error);
        }

        while ($row = $result->fetch_assoc()) {
            echo "<tr>
                    <td>{$row['event_id']}</td>
                    <td>{$row['title']}</td>
                    <td>{$row['date']}</td>
                    <td>{$row['status']}</td>
                    <td>{$row['participants']}</td>
                </tr>";
        }
        ?>
    </table>

    <!-- User Registration Statistics Chart -->
    <div class="chart-container">
        <h3>User Registration Statistics</h3>
        <canvas id="userChart"></canvas>
        <?php
        $userData = $conn->query("SELECT COUNT(user_id) AS num_users, MONTH(registration_date) AS month 
                                  FROM registrations 
                                  GROUP BY month");

        if (!$userData) {
            die("Query Error: " . $conn->error);
        }

        $months = [];
        $userCounts = [];
        while ($row = $userData->fetch_assoc()) {
            $months[] = date('F', mktime(0, 0, 0, $row['month'], 10));
            $userCounts[] = $row['num_users'];
        }
        ?>
        <script>
            const ctx = document.getElementById('userChart').getContext('2d');
            const userChart = new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: <?php echo json_encode($months); ?>,
                    datasets: [{
                        label: 'User Registrations',
                        data: <?php echo json_encode($userCounts); ?>,
                        backgroundColor: 'rgba(54, 162, 235, 0.6)',
                        borderColor: 'rgba(54, 162, 235, 1)',
                        borderWidth: 1
                    }]
                },
                options: {
                    scales: {
                        y: { beginAtZero: true }
                    }
                }
            });
        </script>
    </div>
</div>
</body>
</html>
