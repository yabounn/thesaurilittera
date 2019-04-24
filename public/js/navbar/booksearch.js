$(document).ready(function () {

    $("#searchForm").submit(function (e) {
        e.preventDefault();

        var search = $("#search").val();
        // console.log(search);
        
        $.ajax({
            url: "https://www.googleapis.com/books/v1/volumes?q=" + search,
            dataType: "json",
            type: 'GET',

            success: function (data) {
                console.log(data)
            }
        });
    });
});







// function booksearch() {
// console.log('Cette fonction est ok !');
// var search = document.getElementById('search-input').value
// document.getElementById('results').innerHTML = ""
// console.log(search)

// $.ajax({
//     url: "https://www.googleapis.com/books/v1/volumes?q=" + search,
//     dataType: "json",

//     success: function(data) {
//         console.log(data)
//     },

//     type: 'GET'
// });
// }

// document.getElementById('button-search').addEventListener('click', booksearch, false);