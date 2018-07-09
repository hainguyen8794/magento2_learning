define([
    "jquery",
    "jquery/ui",
], function($) {
    "use strict";

    return {
        loadComments : function(config){

            var AjaxCommentLoadUrl = config.AjaxCommentLoadUrl;
            var AjaxPostId = config.AjaxPostId;
            $.ajax({
                url: AjaxCommentLoadUrl,
                type: 'POST',
                data: {
                    post_id: AjaxPostId
                }
            }).done(function(data){
                alert('asdfadfads');
                var comments = data.items;
                console.log(data);
                var html = ' <div><ul class="blog-post-list">';
                comments.forEach(function(cmt){
                    html += '<li class="blog-post-list-item">'+cmt.author;
                    html += '<div class="blog-post-item-content">'+cmt.content+'</div>';
                    html += '<div class="blog-post-item-meta">';
                    html += '<small>Created at:'+cmt.creation_time+'</small>';
                    html += '</div>';
                    html += '</li></div>';
                });

                html += '</ul>';
                $('#data').html(html);

            });
        }
    };
});