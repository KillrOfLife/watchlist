$(document).ready(function () {

    document.getElementById('search').focus();

    $("#submit").click(function (e) {

        var validate = Validate();
        $("#message").html(validate);
        if (validate.length == 0) {
            CallAPI(1);
        }
    });
  
    function CallAPI(page) {
        var search
        
        switch($("#typeSelector").val()){
            case 'serie': 
                search = 'tv';
                break;
            case 'movie': 
                search = 'movie';
                break;
        }
        
        $.ajax({
            url: "https://api.themoviedb.org/3/search/" + search + "?language=en-US&query=" + $("#search").val() + "&page=" + page + "&include_adult=false",
            data: { "api_key": "4bbcf6ac4f3da5d9fcb7dc5e527e793f" },
            dataType: "json",
            success: function (result, status, xhr) {
                console.log(result)
                var resultHtml = $("<div class=\"resultDiv\">");
                for (i = 0; i < result["results"].length; i++) {
  
                    var image = result["results"][i]["poster_path"] == null ? "Image/no-image.png" : "https://image.tmdb.org/t/p/w500/" + result["results"][i]["poster_path"];
  
                    resultHtml.append("<div class=\"result\" resourceId=\"" + result["results"][i]["id"] + "\" type=\"" + search + "\">" + "<img src=\"" + image + "\" />" + "<p><a>" + result["results"][i]["name"] + "</a></p></div>");
                }
  
                resultHtml.append("</div>");
                $("#message").html(resultHtml);
                Paging(result["total_pages"]);
            },
            error: function (xhr, status, error) {
                $("#message").html("Result: " + status + " " + error + " " + xhr.status + " " + xhr.statusText)
            }
        });
    }
  
    function Validate() {
        var errorMessage = "";
        if ($("#search").val() == "") {
            errorMessage += "► Enter Search Text";
        }
        return errorMessage;
    }
  
    function Paging(totalPage) {
        var obj = $("#pagination").twbsPagination({
            totalPages: totalPage,
            visiblePages: 5,
            onPageClick: function (event, page) {
                CallAPI(page);
            }
        });
    }


    $("#message").on("click", ".result", function () {
        var resourceId = $(this).attr("resourceId");
        var type = $(this).attr("type");
        $("#message").html("");
        $("#pagination").html("");
        $.ajax({
            url: "https://api.themoviedb.org/3/" + type + "/" + resourceId + "?language=en-US",
            data: {
                api_key: "4bbcf6ac4f3da5d9fcb7dc5e527e793f"
            },
            dataType: 'json',
            success: function (result, status, xhr) {
                

                if(type=='tv'){
                    var name = result['name'];
                    var TMDBID = result['id'];
                    var other = "<strong>Status:</strong> " + result['status']+
                                "\n<strong>number of seasons:</strong> " + result['number_of_seasons']+ 
                                "\n<strong>last air date:</strong> " + result['last_air_date']+
                                "\n<strong>overview:</strong> " + result['overview'];
                }else{
                    var name = result['title'];
                    var TMDBID = result['id'];
                    var other = "<strong>Status:</strong> " + result['status']+
                                "\n<strong>Release date:</strong> "+ result['release_date']+
                                "\n<strong>Overview:</strong> " + result['overview'];
                }

               

                $("#name").val(name);
                $("#TMDBID").val(TMDBID);
                document.getElementById("type").options[(type=='tv')?0:1].selected = true;
                $("#other").html(other)
            },
            error: function (xhr, status, error) {
                $("#message").html("Result: " + status + " " + error + " " + xhr.status + " " + xhr.statusText)
            }
        });
    });
});

