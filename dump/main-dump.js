$(document).ready(function() {
    window.history.replaceState("","",window.location.href)

    panelIds()
    // header()
    aside()
    breadcrumb()
    bulletinboard()
    actions()
    // fileIcons()
    reverseTables()
    searchPosts()
    api()
    slide()

    dragNDrop()
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
        $('span[data-menu=monthly-dashboard]').addClass('header__item--active')
        $('.content[data-content=monthly-dashboard]').addClass('content--active')
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
    $('.aside__button').on('click', function() {
        $('.aside').toggleClass('aside--active')
    })

    $('.notifications__file').on('click', function() {
        sectionId = window.location.hash
        let menuItem = $(sectionId).closest('section').data('content')

        $('span').removeClass('aside__item--active')
        $('span[data-menu='+menuItem+']').addClass('aside__item--active')
        $('.content').removeClass('content--active')
        $('.content[data-content='+menuItem+']').addClass('content--active')
    })

    if (window.location.hash && $('body').hasClass('single-hotels')) {
        sectionId = window.location.hash
        let menuItem = $(sectionId).closest('section').data('content')

        $('[data-menu='+menuItem+']').addClass('aside__item--active')
        $('.content[data-content='+menuItem+']').addClass('content--active')
    } else {
        if($('body[data-role="contributor"]').length > 0) {
            $('[data-menu=home]').addClass('aside__item--active')
            $('.content[data-content=home]').addClass('content--active')
        } else {
            $('[data-menu=monthly-dashboard]').addClass('aside__item--active')
            $('.content[data-content=monthly-dashboard]').addClass('content--active')
        }
    }

    $('[data-menu], .aside__item').on('click', function() {
        $(this).siblings('.aside__item-submenu').slideToggle(100, 'linear')
        
        if($(this).hasClass('aside__item')) {
            $('[data-menu], .aside__item').removeClass('aside__item--active')
        }

        if($(this).siblings().hasClass('aside__item--active')) {
            $(this).siblings().removeClass('aside__item--active')
        }

        if($(this).siblings().hasClass('aside__nav')) {
            $(this).siblings('.aside__nav').slideToggle(100, 'linear')
        }

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

        if($(this).data('menu') !== undefined) {
            if($(this).data('menu') == 'home') {
                $('.breadcrumb').hide()
            } else {
                $('.breadcrumb').show()
            }

            $('.content').removeClass('content--active')
            $('.content[data-content='+$(this).data('menu')+']').addClass('content--active')
        }

        breadcrumb()
    })

    $('.aside__item-head').on('click', function() {
        $(this).next('.aside__item-submenu-sub').slideToggle(100, 'linear')
    })
}

function breadcrumb() {
    if($('.breadcrumb').siblings('[data-content=home]').hasClass('content--active')) {
        $('.breadcrumb').hide()
    }
    $('.breadcrumb > *:nth-child(n+4)').remove()
    let activeContent = $('.content--active').data('content')
    let breadcrumbLastItem = '<span>' + $('[data-menu='+activeContent+']').text() + '</span>'
    let breadcrumbItem

    if($('.aside__item[data-menu='+activeContent+']').parent('.aside__submenu').length) {
        breadcrumbItem = '<span>' + $('.aside__item[data-menu='+activeContent+']').parent('.aside__submenu').parent().find('.aside__item h4').first().text() + '</span>'
    } else {
        breadcrumbItem = ''
    }

    $('.breadcrumb > *:last-child').after(breadcrumbItem + breadcrumbLastItem)
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

    $('body').on('click', '.table__row-controls-view', function() {
        window.open($(this).data('url'), '_blank').focus();
    })

    $('body').on('click', '.table__row-controls-share', function() {
        copyToClipboard($(this).parent().find('.table__row-controls-view').data('url'))
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
        // console.log('Text copied to clipboard: ' + text);
        alert("Link copied to clipboard: " + text);
    })
    .catch(function(err) {
        console.error('Unable to copy text to clipboard: ', err);
        alert("Unable to copy link to clipboard. Please try again.");
    });
}

function reverseTables() {
    let tbody = $('.table:not(.table--new) .table__body');

    tbody.each(function() {
        let rows = $(this).find('.table__row').get();
        let lastIndex = rows.length;

        if (lastIndex > 0) {
            let rowsToReverse = rows.slice(0, lastIndex);
            rowsToReverse.reverse();
            $(this).empty().append(rowsToReverse);
            $(this).append(rows[lastIndex]);
        }
    })
}

function panelIds() {
    $('main > section h3').each(function() {
        $(this).closest('.card').attr('id', $(this).text().replace(/\s+/g, '-').toLowerCase())
    })

    $('.card__header').on('click', function() {
        if(!$(this).parent().hasClass('card--noresize')) {
            $(this).siblings().slideToggle(100, 'linear')
        }
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

function fileIcons() {
    let color

    $('a[href$=".pdf"]').each(function() {
        color = '#fc5f4c'
        $(this).closest('tr').find('td:first-of-type').prepend('<figure><svg id="eB0JEjPqx6d1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 39 49" shape-rendering="geometricPrecision" text-rendering="geometricPrecision">\
        <path d="M4.615079,2.653579L27.5022,2.570655l8.872906,10.531393v32.920968h-31.760027v-43.369437Z" fill="none" stroke="#434343" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"/>\
        <path d="M26.38157,2.570652v10.531393h9.993536L27.5022,2.570652h-1.12063Z" transform="translate(0 0.000003)" fill="#434343" stroke="#434343" stroke-width="0.5" stroke-linejoin="round"/>\
        <path d="M2.031101,24.296836L31.958601,24.5v14.422172h-29.9275v-14.625336Z" fill="'+color+'" stroke="'+color+'" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>\
        </svg></figure>')
    });

    $('a[href$=".xls"], a[href$=".xlsx"]').each(function() {
        color = '#107c41'
        $(this).closest('tr').find('td:first-of-type').prepend('<figure><svg id="eB0JEjPqx6d1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 39 49" shape-rendering="geometricPrecision" text-rendering="geometricPrecision">\
        <path d="M4.615079,2.653579L27.5022,2.570655l8.872906,10.531393v32.920968h-31.760027v-43.369437Z" fill="none" stroke="#434343" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"/>\
        <path d="M26.38157,2.570652v10.531393h9.993536L27.5022,2.570652h-1.12063Z" transform="translate(0 0.000003)" fill="#434343" stroke="#434343" stroke-width="0.5" stroke-linejoin="round"/>\
        <path d="M2.031101,24.296836L31.958601,24.5v14.422172h-29.9275v-14.625336Z" fill="'+color+'" stroke="'+color+'" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>\
        </svg></figure>')
    });

    $('table tr td').each(function() {
        if($(this).find('figure').length > 0) {
            $(this).css('padding-left', '5.5rem');
        }

        $(this).find('a').each(function() {
            if($(this).text() == 'View') {
                $(this).addClass('view-btn')
            }
        })

        $(this).find('.material-symbols-outlined').each(function() {
            if($(this).text() == 'share') {
                $(this).addClass('share-btn')
            }
        })
    })
}

function dragNDrop() {
    var dropZone = $('#drop-zone');

    dropZone.on('drag dragstart dragend dragover dragenter dragleave drop', function(e) {
      e.preventDefault();
      e.stopPropagation();
    });

    dropZone.on('dragover dragenter', function() {
      $(this).addClass('drag-over');
    });

    dropZone.on('dragleave dragend drop', function() {
      $(this).removeClass('drag-over');
    });

    dropZone.on('drop', function(e) {
      var files = e.originalEvent.dataTransfer.files;
      handleFiles(files);
    });

    function handleFiles(files) {
      // Handle dropped files here
      console.log(files);
    }
}

function slide() {
    $('.card--statistics .card__body').slick({
        dots: true
    })
}