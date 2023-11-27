<?php
  $servername = "localhost";
  $username = "root";
  $password = "123qwe!@";
  $database = "graduate_calc";

  $selectedItems = json_decode($_COOKIE['selectedItems'], true);
  $courseNum = array();//학수번호
  $needMajorCourseNum = array();//필수전공 학수번호
  //학점 변수
  $totalCredit = 0;
  $donggukEsCredit = 0;
  $GESCredit = 0;
  $baiscCredit = 0;
  $majorCredit = 0;
  
  foreach($selectedItems as $item){ //영역별 과목정보 저장
    $name = $item['name'];
    $value = json_decode($item['value'],true);
    switch($name){
      case '동국소양':
        array_push($courseNum,$value[0]);
        $donggukEsCredit += $value[2];
        $totalCredit += $value[2];
        break;
      case '교양':
        array_push($courseNum,$value[0]);
        $GESCredit += $value[2];
        $totalCredit += $value[2];
        break;
      case '기초교육':
        array_push($courseNum,$value[0]);
        $baiscCredit += $value[2];
        $totalCredit += $value[2];
        break;
      case '전공':
        array_push($courseNum,$value[0]);
        $majorCredit += $value[2];
        $totalCredit += $value[2];
        break;
      case '타전공':
        array_push($courseNum,$value[0]);
        $GESCredit += $value[2];
        $totalCredit += $value[2];
        break;
    }    
  }
  //connection
  $connection = new mysqli($servername, $username, $password, $database);

  //check conn
  if ($connection->connect_error){
    die("connection failed:" . $connection->connect_error);
  }
  $sql1 = "SELECT * FROM 졸업요건 WHERE 학번 = '". $selectedItems[0]['value'] ."'";
  $result1 = $connection->query($sql1);
  $data1 = $result1 -> fetch_row();
$dataPoints1 = array(
  array("label"=> "동국소양", "y"=> $donggukEsCredit),
  array("label"=> "기초교육", "y"=> $baiscCredit),
  array("label"=> "교양", "y"=> $GESCredit),
  array("label"=> "전공", "y"=> $majorCredit),
  array("label"=> "총학점", "y"=> $totalCredit) 
);
$dataPoints2 = array(
  array("label"=> "동국소양", "y"=> $data1[1]),
  array("label"=> "기초교육", "y"=> $data1[2]),
  array("label"=> "교양", "y"=> $data1[3]),
  array("label"=> "전공", "y"=> $data1[4]),
  array("label"=> "총학점", "y"=> $data1[5])
);

$sql2 = "SELECT 학수번호 FROM 졸업필수";
$result2 = $connection->query($sql2);
while ($row = mysqli_fetch_row($result2)){
  $needMajorCourseNum[] = $row[0];
}
$needMajorCourseNum = array_diff($needMajorCourseNum,$courseNum);


?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8" />
    <meta
      name="viewport"
      content="width=device-width, initial-scale=1, shrink-to-fit=no"
    />
    <link
      href="https://fonts.googleapis.com/css?family=Roboto:300,400&display=swap"
      rel="stylesheet"
    />
    <link rel="stylesheet" href="fonts/icomoon/style.css" />
    <link rel="stylesheet" href="css/owl.carousel.min.css" />
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="css/bootstrap.min.css" />

    <!-- Style -->
    <link rel="stylesheet"  href="css/style.css" />
    <title>Dongguk Calc</title>
    <style>
      body {
        font-family: Consolas, monospace;
        font-family: 12px;
      }
      table {
        width: 100%;
      }
      th, td {
        padding: 10px;
        border-bottom: 1px solid #dadada;
      }
    </style>

    <script>
  window.onload = function () {
  
  var chart = new CanvasJS.Chart("chartContainer", {
    animationEnabled: true,
    theme: "light2",
    title:{
      text: "졸업학점 계산 결과"
    },
    axisY:{
      includeZero: true
    },
    legend:{
      cursor: "pointer",
      verticalAlign: "center",
      horizontalAlign: "right",
      itemclick: toggleDataSeries
    },
    data: [{
      type: "column",
      name: "본인 수강",
      indexLabel: "{y}",
      yValueFormatString: "#0.##",
      showInLegend: true,
      dataPoints: <?php echo json_encode($dataPoints1, JSON_NUMERIC_CHECK); ?>
    },{
      type: "column",
      name: "졸업 요건",
      indexLabel: "{y}",
      yValueFormatString: "#0.##",
      showInLegend: true,
      dataPoints: <?php echo json_encode($dataPoints2, JSON_NUMERIC_CHECK); ?>
    }]
  });
  chart.render();
  
  function toggleDataSeries(e){
    if (typeof(e.dataSeries.visible) === "undefined" || e.dataSeries.visible) {
      e.dataSeries.visible = false;
    }
    else{
      e.dataSeries.visible = true;
    }
    chart.render();
  }
  
  }
  </script>
  </head>
  <body>
    <div class="content">
      <div class="container">
        <h1 style="text-align: center;">동국대학교 졸업학점 계산기</h1>
        <hr>
        <div id="chartContainer" style="background-color: blue; height: 370px; width: 100%;"></div>
        <br><br><br>
        <h2 style="text-align: center;">미이수 필수 전공 과목</h2>
        <?php
        if(empty($needMajorCourseNum)){
          echo'<div>비어있습니다.</div>';
        }else{
          echo'
          <table>
            <thead>
              <tr>
                <th>학수번호</th>
                <th>교과목명</th>
                <th>학점</th>
              </tr>
            </thead>
            <tbody>
            ';
            $courseNumString = "'" . implode("','", $needMajorCourseNum) . "'";
            $sql3 = "select * from 졸업필수 where 학수번호 in ($courseNumString)";
            $result3 = $connection->query($sql3);
            while($row = $result3 -> fetch_assoc()){
              echo '<tr>';
              echo '<td>'. $row[ '학수번호' ]. '</td>';
              echo '<td>'. $row[ '교과목명' ]. '</td>';
              echo '<td>'. $row[ '학점' ]. '</td>';
              echo '</tr>';
            }
            echo '</tbody></table>';
        }
        ?>
        <button type="button" class="btn btn-secondary" id= "prev_btn">&lt; prev</button>
      </div>
    </div>
    

  </body>
  
  <script src="js/jquery-3.3.1.min.js"></script>
  <script src="js/popper.min.js"></script>
  
  <script src="https://cdn.canvasjs.com/canvasjs.min.js"></script>
  <script src="js/bootstrap.min.js"></script>
  <script src="js/main.js"></script>
  <script src="js/cookie.js"></script>
  <script>
    const prev = document.getElementById("prev_btn");

    prev.addEventListener("click", function () {
      window.location.href = "./test4.php";
    });
  </script>
</html>
