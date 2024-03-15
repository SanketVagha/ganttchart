<?php 

function getData(){
  include("connection.php");
  $data = array();
  $sql = "select * from ganttchart";
  $result = $conn->query($sql);

  if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
      $data[] = $row;
    }
    return json_encode( $data );
  }
}

?>
<html>
<head>
  <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
  
</head>
<body>
  <a href="http://localhost/ganttchart/form.php" style="font-size: 20px; margin-bottom: 20px;">Add</a>
  <div id="chart_div" style="margin-top: 20px"></div>
  <?php
  ?>
  <script type="text/javascript">
    google.charts.load('current', {'packages':['gantt']});
    google.charts.setOnLoadCallback(drawChart);

    function daysToMilliseconds(days) {
      // console.log(days);
      return days * 24 * 60 * 60 * 1000;
    }

    function drawChart() {

      var data = new google.visualization.DataTable();
      data.addColumn('string', 'Task ID');
      data.addColumn('string', 'Task Name');
      data.addColumn('date', 'Start Date');      
      data.addColumn('date', 'End Date');
      data.addColumn('number', 'Duration');
      data.addColumn('number', 'Percent Complete');
      data.addColumn('string', 'Dependencies');

      const result = <?php print_r( getData()) ?>;

      result.forEach(element => {
        data.addRow([
          element['id'] !== undefined ? element['id'] : null,
          element['name'] !== null ? element['name'] : null,
          // null,
          element['startDate'] !== null ? new Date(element['startDate']) : null,
          element['endDate'] !== null ? new Date(element['endDate']) : null,
          element['duration'] !== null ? daysToMilliseconds(Number(element['duration'])) : 0,
          element['complete'] !== null ? parseInt(element['complete']) : null,
          element['dependencies'] !== null ? element['dependencies'] : null      
        ]);
      });
      var options = {
        height: 5000
      };

      var chart = new google.visualization.Gantt(document.getElementById('chart_div'));

      chart.draw(data, options);
    }
  </script>
</body>
</html>
