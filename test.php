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
  </head>
  <body>
    <div class="content">
      <div class="container">
        <h1 style="text-align: center;">동국대학교 졸업학점 계산기</h1>
        <hr>
        <h2 class="mb-5">동국소양 입력</h2>
        <label for="search-box">
          <string>search</string>
        </label>
        <input type="search" id="search-box" />

        <div class="table-responsive custom-table-responsive" style="height: 500px; overflow:auto">
          <table class="table custom-table" id="table">
            <thead>
              <tr>
                <th scope="col">
                  <label class="control control--checkbox">
                    <input type="checkbox" class="js-check-all" />
                    <div class="control__indicator"></div>
                  </label>
                </th>

                <th scope="col">학수번호</th>
                <th scope="col">과목명</th>
                <th scope="col">학점</th>
              </tr>
            </thead>
            <tbody>
              <?php
              require_once('dbConnection.php');
              //read table

              $sql="SELECT * FROM 2023교양 where 학수번호 like 'DDC%' ";
              $result = $connection->query($sql);

              //read data
              if (!$result){
                die("connection failed:" . $connection->error);
              }

              while($row = $result -> fetch_assoc()){
                echo"
                <tr>
                <th scope='row'>
                  <label class='control control--checkbox'>
                  <input type='checkbox' name='동국소양' value = '[&quot;". $row["학수번호"]. "&quot;,&quot;". $row["교과목명"]. "&quot;,". $row["학점"]. "]' />
                  <div class='control__indicator'></div>
                  </label>
                </th>
                <td>". $row["학수번호"] ."</td>
                <td>". $row["교과목명"] ."</td>
                <td>". $row["학점"] ."</td>
              </tr>
              <tr class='spacer'>
                <td colspan='100'></td>
              </tr>
                ";
              }
              ?>
            </tbody>
          </table>
        </div>
        <button type="button" class="btn btn-secondary" id= "prev_btn">&lt; prev</button>
        <button type="button" class="btn btn-secondary" id= "next_btn">next &gt;</button>
      </div>
    </div>
    

  </body>
  
  <script src="js/jquery-3.3.1.min.js"></script>
  <script src="js/popper.min.js"></script>
  <script src="js/bootstrap.min.js"></script>
  <script src="js/main.js"></script>
  <script src="js/search.js"></script>
  <script src="js/cookie.js"></script>
  <script>
    let next = document.getElementById("next_btn");
    const prev = document.getElementById("prev_btn");

    next.addEventListener("click", function () {
    let existingItems = getCookie("selectedItems");
    existingItems = JSON.parse(existingItems);
    const checkboxes = document.querySelectorAll('input[type="checkbox"]:checked');
    checkboxes.forEach((checkbox) => {
      const name = checkbox.name;
      const value = checkbox.value;
      existingItems.push({name,value});
    });
    const jsonData = JSON.stringify(existingItems);
    console.log(jsonData);
      document.cookie = "selectedItems=" + jsonData;
      window.location.href = "./test1.php";
    });
    prev.addEventListener("click", function () {
      window.location.href = "./main.php";
    });
  </script>
</html>
