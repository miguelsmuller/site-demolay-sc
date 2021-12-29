/*global common_params:false, Instafeed:false*/
jQuery(document).ready(function($) {
    var paged = 2;

    $( '#load-more' ).click(function() {
        var template = $(this).attr('data-template');
        var post_type = $(this).attr('data-post-type');
        var posts_per_page = $(this).attr('data-posts-per-page');
        var data_max_page = $(this).attr('data-max-page');

        if (paged > data_max_page){
            return false;
        }else{
            loadArticle(template, post_type, posts_per_page, paged);
        }
        paged++;
    });

    function loadArticle(template, post_type, posts_per_page, paged) {
        $( '#load-more' ).button('loading');
        $.ajax({
            url: common_params.site_url + '/wp-admin/admin-ajax.php',
            type:'POST',
            data: 'action=infinite_scroll&template='+ template + '&post_type='+ post_type + '&posts_per_page=' + posts_per_page +'&paged='+ paged,
            success: function(html){
                $('#article-list').append(html);
                $( '#load-more' ).button('reset');
            }
        });
        return false;
    }

    if ($('#instagram').length){
        var feed = new Instafeed({
            get: 'tagged',
            tagName: 'demolaysc',
            clientId: '3786c6b7c4a449579be93f561d8c96e5',
            limit:20,
            sortBy:'most-recent',
            template:'<a href="{{link}}" target="_blank"><img data-toggle="tooltip_instafeed" title="{{caption}}" src="{{image}}" class="instagram-image" /></a>',
            after:function() {
                $('[data-toggle=tooltip_instafeed]').tooltip();
            }
        });
        feed.run();
    }
    $('.dropdown-menu-content').click(function (e) {
        e.stopPropagation();
    });
});
