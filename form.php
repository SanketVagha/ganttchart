<?php
include("connection.php");
    if ($_SERVER['REQUEST_METHOD'] == "POST") {
        $name = ' ';
        $startDate = ' ';
        $endDate = ' ';
        $duration = 0;
        $complete = 0;
        $dependencies =  ' ';

        if ($_REQUEST['name']) {
            $name = $_REQUEST['name'];
        }
        
        if ($_REQUEST['startDate']) {
            $startDate = $_REQUEST['startDate'];
        }

        if ($_REQUEST['endDate']) {
            $endDate = $_REQUEST['endDate'];
        }

        if ($_REQUEST['duration']) {
            $duration = $_REQUEST['duration'];
        }
        
        if ($_REQUEST['complete']) {
            $complete = $_REQUEST['complete'];
        }

        if ($_REQUEST['dependencies']) {
            $dependencies = implode("," , $_REQUEST['dependencies']);
        }
        
        // print_r($_REQUEST);
        $sql = "Insert into ganttchart(`name`, `startDate`, `endDate`, `duration`, `complete`, `dependencies`) VALUES ('$name', '$startDate', '$endDate', $duration, $complete, '$dependencies')";
        
        if ($conn->query($sql)) {
            print($sql);
            header("Location: http://localhost/ganttchart/ganttchart.php");
            exit();
        }
    }

    $sql = "select * from ganttchart";
    $result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <form action="" method="post">
        <div class="form-group">
            <label for="name">Name</label>
            <input type="text" name="name" id="name">
        </div>
        <div class="form-group">
            <label for="startDate">Start Date</label>
            <input type="date" name="startDate" id="startDate">
        </div>
        <div class="form-group">
            <label for="endDate">End Date</label>
            <input type="date" name="endDate" id="endDate">
        </div>
        <div class="form-group">
            <label for="duration">Duration</label>
            <input type="number" name="duration" id="duration">
        </div>
        <div class="form-group">
            <label for="complete">Complete</label>
            <input type="number" name="complete" id="complete">
        </div>
        <div class="form-group">
            <label for="dependencies">Dependencies</label>
            <?php
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                        ?>

                        <input type="checkbox" name="dependencies[]" id="<?php echo $row['id'] ?>" value="<?php echo $row['id'] ?>"> <?php echo $row['name'] ?>
                        <?php                    
                }
            }
            ?>
        </div>
        <div class="form-group">
            <input type="submit" value="submit">
        </div>
    </form>
</body>
</html>