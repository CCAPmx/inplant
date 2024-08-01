

var table = document.getElementById("myTable");
var tbody = table.getElementsByTagName("tbody")[0];
var paginationContainer = document.getElementById("pagination");

var rowsPerPage = 5; // Número de filas por página
var currentPage = 1; // Página actual


$(document).ready(function () {
  mostrarLoader();

const pk = $.trim(document.getElementById('txtpk').value);


});

function mostrarLoader() {
  document.getElementById("loader").style.display = "block";
}

 
function ocultarLoader() {
  document.getElementById("loader").style.display = "none";
}

function goToPage(page) {
    currentPage = page;
    var start = (currentPage - 1) * rowsPerPage;
    var end = start + rowsPerPage;
  
    displayData(start, end);
  }
