// $(document).ready(function () {

//     $("#searchForm").submit(function (e) {
//         e.preventDefault();

//         var search = $("#search").val();
//         // console.log(search);

//         $.ajax({
//             url: "https://www.googleapis.com/books/v1/volumes?q=" + search,
//             dataType: "json",
//             type: 'GET',

//             success: function (data) {
//                 console.log(data)
//             }
//         });
//     });
// });

function booksearch(e) {
    e.preventDefault();

    var search = document.getElementById('search').value
    document.getElementById('result').innerHTML = ""
    // console.log(search);

    $.ajax({
        url: "https://www.googleapis.com/books/v1/volumes?q=" + search,
        dataType: "json",
        type: 'GET',

        success: function (data) {
            console.log(data)
            // for(i=0; i < data.items.length; i++){
            //     result.innerHTML += "<h2>" + data.items[i].volumeInfo.title + "</h2>"
            // }
        }
    });
}
document.getElementById('button').addEventListener('click', booksearch, false);







