$(document).ready(function() {
    window.history.replaceState("","",window.location.href)

    panelIds()
    // header()
    aside()
    bulletinboard()
    actions()
    linkUpdate()
    reverseTables()
    searchPosts()
    api()
    // feed('https://www.regiotels.com/feed/')
})

document.addEventListener("DOMContentLoaded", function(event) { 
    var scrollpos = localStorage.getItem('scrollpos');
    if (scrollpos) window.scrollTo(0, scrollpos);
});

window.onbeforeunload = function(e) {
    localStorage.setItem('scrollpos', window.scrollY);
};

function showLoadingScreen() {
    $('.loading-screen').addClass('loading-screen--active');
}

function hideLoadingScreen() {
    $('.loading-screen').removeClass('loading-screen--active');
}

function header() {
    if (window.location.hash && $('body').hasClass('single-hotels')) {
        sectionId = window.location.hash
        let menuItem = $(sectionId).closest('section').data('content')

        $('span[data-menu='+menuItem+']').addClass('header__item--active')
        $('.content[data-content='+menuItem+']').addClass('content--active')
    } else {
        if(localStorage.getItem('menu')) {
            let menuItem = localStorage.getItem('menu')
            $('span[data-menu='+menuItem+']').addClass('header__item--active')
            $('.content[data-content='+menuItem+']').addClass('content--active')
        } else {
            $('span[data-menu=administration]').addClass('header__item--active')
            $('.content[data-content=administration]').addClass('content--active')
        }
    }

    $('.header__item').on('click', function() {
        $('.header__item').removeClass('header__item--active')

        if($(this).parent().hasClass('header__submenu')) {
            $('.header__item').removeClass('header__item--active')
            $('.header__submenu span').removeClass('header__item--active')
            $(this).closest('.header__item').addClass('header__item--active')
            $(this).addClass('header__item--active')
        } else {
            $(this).addClass('header__item--active')
        }
        
        $('.content').removeClass('content--active')
        $('.content[data-content='+$(this).data('menu')+']').addClass('content--active')

        let menu = $(this).data('menu')

        localStorage.setItem('menu', menu)
    })
}

function aside() {
    $('.aside button').on('click', function() {
        $('.aside').toggleClass('aside--active')
    })

    $('.aside__hotels h2').on('click', function() {
        $(this).siblings('nav').slideToggle(100, 'linear')
    })

    $('.card__header').on('click', function() {
        // $(this).parent().toggleClass('card--minimal')
        $(this).siblings().slideToggle(100, 'linear')
    })

    if (window.location.hash && $('body').hasClass('single-hotels')) {
        sectionId = window.location.hash
        let menuItem = $(sectionId).closest('section').data('content')

        $('span[data-menu='+menuItem+']').addClass('aside__item--active')
        $('.content[data-content='+menuItem+']').addClass('content--active')
    } else {
        if(localStorage.getItem('menu')) {
            let menuItem = localStorage.getItem('menu')
            $('span[data-menu='+menuItem+']').addClass('aside__item--active')
            $('.content[data-content='+menuItem+']').addClass('content--active')
        } else {
            $('span[data-menu=administration]').addClass('aside__item--active')
            $('.content[data-content=administration]').addClass('content--active')
        }
    }

    $('.aside__item').on('click', function() {
        $('.aside__item').removeClass('aside__item--active')

        if($(this).siblings().hasClass('aside__submenu')) {
            $(this).siblings().slideToggle(100, 'linear')
            $('.aside__item').removeClass('aside__item--active')
            $('.aside__submenu span').removeClass('aside__item--active')
            $(this).closest('.aside__item').addClass('aside__item--active')
            $(this).addClass('aside__item--active')
            
            if($(this).find('span').text() == 'add') {
                $(this).find('span').text('remove')
            } else {
                $(this).find('span').text('add')
            }
        } else {
            $(this).addClass('aside__item--active')
        }

        if($(this).data('menu')) {
            $('.content').removeClass('content--active')
            $('.content[data-content='+$(this).data('menu')+']').addClass('content--active')
            let menu = $(this).data('menu')
            localStorage.setItem('menu', menu)
        }
    })
}

function breadcrumb() {
    
}

function bulletinboard() {
    $('.news__category-item').on('click', function() {
        let category = $(this).data('category')

        $('.news__category-item').removeClass('news__category-item--active')
        $(this).toggleClass('news__category-item--active')

        if(category == 'all') {
            $(this).closest('.news__board').find('.news__container .news__item').show()
        } else {
            $(this).closest('.news__board').find('.news__container .news__item[data-category="'+category+'"]').show()
            $(this).closest('.news__board').find('.news__container .news__item:not([data-category="'+category+'"])').hide()
        }
    })

    $('.news__board button').on('click', function() {
        $('.news__bulletin').toggleClass('news__bulletin--active')
        $('.news__bulletin > div').hide()
    })

    $('.news__bulletin').on('submit', function() {
        $('.news__bulletin').toggleClass('news__bulletin--active')
        $('.news__bulletin > div').show()
        location.reload()
    })

    $('.news__bulletin-close').on('click', function() {
        $('.news__bulletin').toggleClass('news__bulletin--active')
        $('.news__bulletin > div').show()
    })
}

function feed(feedUrl) {
    fetch(feedUrl)
        .then(response => response.text()) // Get the raw XML response
        .then(xml => {
            // Parse the XML response
            const parser = new DOMParser();
            const xmlDoc = parser.parseFromString(xml, 'text/xml');
            // Extract feed information from the XML document
            const title = xmlDoc.querySelector('channel > title').textContent;
            const link = xmlDoc.querySelector('channel > link').textContent;
            const items = xmlDoc.querySelectorAll('item');
            const feedItems = [];
            items.forEach(item => {
                const itemTitle = item.querySelector('title').textContent;
                const itemLink = item.querySelector('link').textContent;
                // You can extract more item information here if needed
                feedItems.push({ title: itemTitle, link: itemLink });
            });
            // Construct the feed information object
            const feedInfo = { title, link, items: feedItems };
            // Process the feed information
            console.log(feedInfo);
            // Display feed information on your web page
        })
        .catch(error => {
            console.error('There was a problem with the fetch operation:', error);
        });
}

function actions() {
    downloadImages()
    gallery()

    $('body').on('click', '.material-symbols-outlined:contains("share")', function() {
        copyToClipboard($(this).parent().find('a').attr('href'))
    })
}

function downloadImages() {
    $('body').on('click', '.download-images', function() {
        let btn = $(this)
        let files = []

        btn.closest('.gallery').find('tbody').find('tr img').each(function() {
            files.push({name: $(this)[0].src.split('/').pop(), content: $(this)[0].src})
        })
                
        // Create a new JSZip instance
        var zip = new JSZip();
        
        // Add files to the zip from the array
        files.forEach(function(file) {
            zip.file(file.name, file.content);
        });
        
        // Generate the zip file content
        zip.generateAsync({ type: "blob" }).then(function (blob) {
            // Create a download link
            var link = document.createElement("a");
            link.href = URL.createObjectURL(blob);
            link.download = $(document).attr('title').split('— ').pop() + ' - ' + btn.closest('.gallery').find('h4').text() + ".zip";
            
            // Append the link to the document
            document.body.appendChild(link);
            
            // Trigger a click on the link to start the download
            link.click();
            
            // Remove the link from the document
            document.body.removeChild(link);
        });
    })
}

function gallery() {
    $('.gallery__images:not(.gallery__images--noslider)').each(function() {
        $(this).slick({
            infinite: false,
            slidesToShow: 1,
            arrows: true,
            dots: true,
            adaptiveHeight: true
        })
    })

    $('body').on('click', '.gallery__images img', function() {
        let galleryContainer = $(this).closest('.gallery')
        galleryContainer.append('<div class="gallery__popup"><button class="gallery__popup-close"><span class="material-symbols-outlined">close</span></button></div>')

        if(galleryContainer.find('.gallery__images--noslider').length > 0) {
            $(this).closest('.gallery__images').removeClass('gallery__images--noslider').clone().appendTo(galleryContainer.find('.gallery__popup'))
            $(this).closest('.gallery__images').addClass('gallery__images--noslider')
        } else {
            $(this).closest('.gallery__images').slick('unslick').clone().appendTo(galleryContainer.find('.gallery__popup'))
            $(this).closest('.gallery__images').slick({
                infinite: false,
                slidesToShow: 1,
                arrows: true,
                dots: true,
                adaptiveHeight: true
            })
        }

        $(this).closest('.gallery__images').parent().find('.gallery__popup .gallery__images').slick({
            infinite: false,
            slidesToShow: 1,
            arrows: true,
            dots: true,
        })
    })

    $('body').on('click', '.gallery__popup-close', function() {
        $(this).parent().remove()
    })
}

function copyToClipboard(text) {
    navigator.clipboard.writeText(text)
    .then(function() {
        console.log('Text copied to clipboard: ' + text);
        alert("Link copied to clipboard: " + text);
    })
    .catch(function(err) {
        console.error('Unable to copy text to clipboard: ', err);
        alert("Unable to copy link to clipboard. Please try again.");
    });
}

function reverseTables() {
    let tbody = $('.repeater-table tbody');

    tbody.each(function() {
        let rows = $(this).find('tr').get();
        let lastIndex = rows.length - 1;

        if (lastIndex > 0) {
            let rowsToReverse = rows.slice(0, lastIndex);
            rowsToReverse.reverse();
            $(this).empty().append(rowsToReverse);
            $(this).append(rows[lastIndex]);
        }
    })
}

function linkUpdate() {
    $('section[data-content] a').each(function() {
        if($(this).closest('.card').hasClass('general-property__photos') == false) {
            let url = $(this).attr('href')
            if (url.startsWith("mailto:") || url.startsWith("tel:")) {
                return "";
            }
            let filelink = url.substring(url.lastIndexOf('/') + 1)
    
            $(this).attr('href', 'http://' + window.location.hostname + '/wp-content/uploads/' +window.location.pathname.split('/').filter(Boolean).pop() + '/2024/04/' + filelink)
        }
    })
}

function panelIds() {
    $('main > section h3').each(function() {
        $(this).closest('.card').attr('id', $(this).text().replace(/\s+/g, '-').toLowerCase())
    })
}

function removeHash() {
    history.replaceState("", document.title, window.location.pathname + window.location.search)
}

function searchPosts() {
    $('.notifications input[type=search]').on('input', function(){
        var query = $(this).val();
        $.ajax({
            url: '/wp-admin/admin-ajax.php',
            type: 'POST',
            data: {
                'action': 'ajax_search',
                'search': query
            },
            success: function(response) {
                $('.notifications__tasks').html(response);
            }
        })
    })
}

function api() {
    // linkedinApi()
}