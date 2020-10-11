/* When the user clicks on the button,
toggle between hiding and showing the dropdown content */
function openPostsDropdown() {
    document.getElementById("PostsDropdown").classList.toggle("show");
}

function filterFunction() {
    var input, filter, ul, li, a, i;
    input = document.getElementById("PostsInput");
    filter = input.value.toUpperCase();
    div = document.getElementById("PostsDropdown");
    a = div.getElementsByTagName("a");
    for (i = 0; i < a.length; i++) {
        txtValue = a[i].textContent || a[i].innerText;
        if (txtValue.toUpperCase().indexOf(filter) > -1) {
            a[i].style.display = "";
        } else {
            a[i].style.display = "none";
        }
    }
}

jQuery(function($){
    $(document).ready(function(){

        $('#PostsDropdown').on( "click", "a", function(){
            var post_id = $(this).attr('href');
            var post_title = $(this).text();
            $(this).addClass('hidden'); 
            $('.selected-posts').append('<p id="'+post_id+'">'+post_title+'<button>Remove</button></p>');
            return false;
        }); 

        $('.icon-box').on( "click", "span", function(){
            $('.icon-box span').removeClass('active');
            $(this).addClass('active');
        });

        $('.icon-box').on( "click", "span", function(){
            $('.icon-box span').removeClass('active');
            $(this).addClass('active');
        });

        $('.icon-position').on( "click", "button", function(){
            $('.icon-position button').removeClass('active');
            $(this).addClass('active');
        });

    });
});