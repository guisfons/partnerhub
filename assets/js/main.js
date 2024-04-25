$(document).ready(function() {
    if(localStorage.getItem('menu')) {
        let menuItem = localStorage.getItem('menu')
        $('span[data-menu='+menuItem+']').addClass('header__item--active')
        $('.content[data-content='+menuItem+']').addClass('content--active')
    } else {
        $('span[data-menu=administration]').addClass('header__item--active')
        $('.content[data-content=administration]').addClass('content--active')
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

    $('.gallery__images:not(.gallery__images--noslider)').each(function() {
        $(this).slick({
            infinite: false,
            slidesToShow: 1,
            arrows: true,
            dots: true,
            adaptiveHeight: true
        })
    })

    $('.card__header').on('click', function() {
        $(this).parent().toggleClass('card--minimal')
        $(this).siblings().slideToggle(100, 'linear')
    })

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

    $('body').on('click', '.material-symbols-outlined:contains("share")', function() {
        copyToClipboard($(this).parent().find('a').attr('href'))
    })

    $('.news__category').on('click', function() {
        let category = $(this).data('category')

        $('.news__category').removeClass('news__category--active')
        $(this).toggleClass('news__category--active')

        if(category == 'all') {
            $(this).closest('.news__items').find('.news__container .news__item').show()
        } else {
            $(this).closest('.news__items').find('.news__container .news__item').hide()
            $(this).closest('.news__items').find('.news__container .news__item:not([data-category="'+category+'"])').show()
        }
    })

    window.history.replaceState("","",window.location.href)

    linkUpdate()
    reverseTables()
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