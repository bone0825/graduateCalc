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

        <h2 class="mb-5">학번 선택</h2>
        

        <div class="table-responsive custom-table-responsive">
          <label for="student_id">
            <string>학번 선택</string>
          </label>
          <form action="">
          <select id = "student_id" name = "학번">
            <option value="18">18학번</option>
            <option value="19">19학번</option>
            <option value="20">20학번</option>
          </select>
          </form>
        <button type="button" class="btn btn-secondary" id= "next_btn">next &gt;</button>
      </div>
    </div>
  </body> 
  <script src="js/jquery-3.3.1.min.js"></script>
  <script src="js/popper.min.js"></script>
  <script src="js/bootstrap.min.js"></script>
  <script src="js/main.js"></script>
  <script src="js/search.js"></script>
  <script>
  const next = document.getElementById("next_btn");

  next.addEventListener("click", function () {
    // 배열을 초기화하여 선택한 항목을 저장합니다.
    const selectedItems = [];
    const selects = document.getElementById('student_id');


    const name = selects.name;
    const value = selects.value;
    selectedItems.push({name,value});

    const jsonData = JSON.stringify(selectedItems);
    var encodedData = encodeURIComponent(jsonData);
      document.cookie = "selectedItems=" + encodedData;
      window.location.href = "./test.php";
    });
  </script>
</html>
