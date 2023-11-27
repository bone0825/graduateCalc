// DOMContentLoaded 이벤트가 발생하면, 콜백함수 실행
document.addEventListener("DOMContentLoaded", function () {
  // 검색창 element를 id값으로 가져오기
  const payrollSearch = document.querySelector("#search-box");
  // 테이블의 tbody element를 id값으로 가져오기
  const payrollTable = document.querySelector("#table tbody");

  //검색창 element에 keyup 이벤트 세팅. 글자 입력 시 마다 발생.
  payrollSearch.addEventListener("keyup", function () {
    // 사용자가 입력한 검색어의 value값을 가져와 소문자로 변경하여 filterValue에 저장
    const filterValue = payrollSearch.value.toLowerCase();
    // 현재 tbody안에 있는 모든 tr element를 가져와 rows에 저장
    const rows = payrollTable.querySelectorAll("tr");

    //tr들 for문으로 순회
    for (var i = 0; i < rows.length; i++) {
      // 현재 순회중인 tr의 textContent를 소문자로 변경하여 rowText에 저장
      var rowText = rows[i].textContent.toLowerCase();
      // rowText가 filterValue를 포함하면, 해당 tr은 보여지게 하고, 그렇지 않으면 숨긴다.
      if (rowText.includes(filterValue)) {
        rows[i].style.display = "";
      } else {
        rows[i].style.display = "none";
      }
    }
  });
});
