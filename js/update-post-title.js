jQuery(function ($) {
    $(document).ready(function () {

        $('.save-posts-info').click(function () {
            //validation 
            var icon_name = $('.icon-box .active').attr('id');
            var icon_position = $('.icon-position .active').text();
            var arrPosts = [];
            $('.selected-posts p').each(function (i) {
                arrPosts[i] = $(this).attr('id');
            });
            if (icon_name == undefined) {
                alert("Select icon");
            } else if (icon_position == "") {
                alert("Select position");
            } else if (arrPosts.length == 0) {
                alert("Select post");
            } else {


                var data = {
                    'action': 'update_post_title',
                    'icon_name': icon_name,
                    'arrPosts': arrPosts,
                    'icon_position': icon_position,
                };

                $.ajax({  
                    url: update_post_title.ajaxurl,
                    data: data,
                    type: 'POST',
                    success: function (data) {
                        if (data) {
                            console.log(data);
                        }  
                        alert("Your posts have been updated") ? "" : location.reload();
                    }
                });
            }

            return false;
        });
        // Remove icon from post title
        $('.selected-posts ').on("click", "button", function () {
            var post_id = $(this).parent().attr('id');
            $(this).parent().remove(); 
            $('#PostsDropdown a[href="' + post_id + '"]').removeClass('hidden');
            $('#PostsDropdown a[href="' + post_id + '"] span').remove();
            var data = {
                'action': 'remove_icon_from_post', 
                'post_id':post_id
            };

            $.ajax({ 
                url: update_post_title.ajaxurl,
                data: data,
                type: 'POST',
                success: function (data) {
                    if (data) {
                        console.log(data);
                    }  
                }
            });
        });
    });
});