$(document).ready(function() {
    window.history.replaceState("","",window.location.href)

    // let searchParams = new URLSearchParams(window.location.search)
    // if(searchParams.has('failed')) {
    //     $('<div class="login__error"><strong>Error: </strong>The username or password provided is incorrect.</div>').insertBefore('.login__form')
    // }

    panelIds()
    header()
    aside()
    breadcrumb()
    bulletinboard()
    actions()
    // fileIcons()
    reverseTables()
    searchPosts()
    api()
    slide()
    // chart()

    dragNDrop()
    hotelSelect()

    if($('body').find('[data-content=request-new-ticket], .card__header select').length) { select() }

    // if($('[data-simplebar]').length) { scrollbar() }
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
    $('.header-user__notification').on('click', function() {
        
    })
}

function aside() {
    $('.aside__button').on('click', function() {
        $('.aside').toggleClass('aside--active')
    })

    $('.notifications__file').on('click', function() {
        sectionId = $(this).data('href')
        let menuItem = $('#'+sectionId).closest('section').data('content')

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
    profile()
    ticket()
    hideMenus()

    $('body').on('click', '.table__row-controls-view', function() {
        window.open($(this).data('url'), '_blank').focus();
    })

    $('body').on('click', '.table__row-controls-share', function() {
        copyToClipboard($(this).parent().find('.table__row-controls-view').data('url'))
    })

    $('body').on('change', '.table__row-form form', function() {
        $(this).closest('.card__body').find('.table__foot-addrow').text('Upload file')
    })

    $('.table:not(.table--new) .table__foot-submit').on('click', function() {
        $(this).closest('.table').find('.table__row-upload').click()
    })
}

function isValidEmail(email) {
    var emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    return emailPattern.test(email);
}

function downloadImages() {
    $('body').on('click', '.table__gallery-download', function() {
        let btn = $(this)
        let files = []
        let promises = []

        btn.closest('.table__gallery').find('figure').each(function() {
            let img = $(this).find('img')[0]
            let src = img.src
            let name = src.split('/').pop()
            promises.push(
                fetch(src)
                    .then(response => response.blob())
                    .then(blob => {
                        files.push({ name: name, content: blob })
                    })
            )
        })

        Promise.all(promises).then(function() {
            var zip = new JSZip()
            files.forEach(function(file) {
                zip.file(file.name, file.content)
            })

            zip.generateAsync({ type: "blob" }).then(function(blob) {
                var link = document.createElement("a")
                link.href = URL.createObjectURL(blob)
                link.download = $(document).attr('title').split('— ').pop() + ' - ' + btn.closest('.content').find('h2').text() + ".zip"
                
                document.body.appendChild(link)
                link.click()
                document.body.removeChild(link)
            });
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

    $('body').on('click', '.table__foot-addgallery', function() {
        $(this).closest('.table').find('.table__body').hide()
        $(this).closest('.table').find('.table__modal').addClass('table__modal--active')

        if($(this).text() == 'Submit picture') {
            $(this).closest('.table').find('.table__modal .upload-gallery').click()
            return false
        }

        if($(this).text() == 'Upload new picture') {
            $(this).text('Submit picture')
        }
    })

    $('.table__foot-viewgallery').on('click', function() {
        let table = $(this).closest('.table')
        let imgData = []
        let fieldKey = $(this).closest('.table').data('field-key')
        let postId = $(this).closest('.table').data('post-id')

        table.find('.table__row').each(function() {
            let imgId = $(this).find('.table__row-title figure').data('image-id')
            let imgUrl = $(this).find('.table__row-controls a').attr('href')

            if (imgId !== undefined && imgUrl !== undefined) {
                let img = {
                    id: imgId,
                    url: imgUrl
                }
                imgData.push(img)
            }
        })

        let oldTitle = $(this).closest('.content').find('h2').text()
        let title = $(this).closest('.card').find('.card__header h3').text()

        $(this).closest('.content').find('.card').hide()
        $(this).closest('.content').find('h2').text('GALLERY - ' + title)

        $(this).closest('.content').append('<div class="table__gallery"></div>')

        $.each(imgData, function(i, value) {
            let id = value.id
            let url = value.url
            let filename = url.substring(url.lastIndexOf('/') + 1)
            let title = filename.substring(0, filename.lastIndexOf('.'))

            table.closest('.content').find('.table__gallery').append('\
                <figure>\
                    <img src="'+url+'" alt="'+title+'" />\
                    <a href="'+url+'" target="_blank" title="'+title+'"><span class="material-symbols-outlined">preview</span></a>\
                    <span class="material-symbols-outlined table__gallery-delete" data-image-id="'+id+'" data-field-key="'+fieldKey+'" data-post-id="'+postId+'">delete</span>\
                </figure>')
        })

        table.closest('.content').find('.table__gallery').append('<span class="material-symbols-outlined table__gallery-close">close</span><button class="table__gallery-download">Download images<span class="material-symbols-outlined">download</span></button>')
    })

    $('body').on('click', '.table__gallery-close', function() {
        $(this).closest('.content').find('h2').text('Property Info')
        $(this).closest('.content').find('.card').attr('style', '')
        $(this).closest('.table__gallery').remove()
    })

    $('.table__foot-back').on('click', function() {
        $(this).closest('.table').find('.table__modal').removeClass('table__modal--active')
        $(this).closest('.table').find('.table__body').css('display', 'flex')
        $(this).siblings('.table__foot-addgallery').text('Upload new picture')
    })
}

function copyToClipboard(text) {
    navigator.clipboard.writeText(text)
    .then(function() {
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
      console.log(files);
    }
}

function slide() {
    $('.card--statistics .card__body').slick({
        dots: true
    })
}

function hotelSelect() {
    $('.hotel-select__selection > span').on('click', function() {
        $('.hotel-select__select').slideDown({
            start: function () {
                $(this).css({display: "flex"})
            }
        })
    })

    $('.hotel-select__select span').on('click', function() {
        let text = $(this).data('title')
        $(this).parent().slideUp()
        $('.hotel-select__select span').attr('data-selected', '')
        $(this).attr('data-selected', 'selected')
        $(this).closest('.hotel-select__selection').find('span').first().text(text)
    })

    $('.hotel-select__btn').on('click', function() {
        let value = $(this).closest('.hotel-select__container').find('.hotel-select__selection [data-selected="selected"]').val()
        let url = $(this).closest('.hotel-select__container').find('.hotel-select__selection [data-selected="selected"]').data('url')
        
        if($(this).closest('.hotel-select__select').find('select').val() != '') {
            window.location.replace(url)
        }
    })
}

function profile() {
    $('.card--profile__edit').on('click', function() {
        let btn = $(this)
        let userId = btn.closest('.card--profile__body').find('input[name=userId]').val()

        if(btn.text() == 'Edit') {
            btn.siblings('input').prop('disabled', false)
            btn.siblings('input').focus().select()
            btn.text('Submit')

            if($(this).siblings('input').attr('type') == 'password') {
                btn.siblings('input').val('').attr('placeholder', 'Password').attr('value', '')
                btn.siblings('input').attr('type', 'text')
            }
        } else {
            if($(this).siblings('input').attr('type') == 'email') {
                let email = btn.siblings('input').val()

                if(isValidEmail(email)) {
                    $.ajax({
                        type: 'POST',
                        url: '/wp-admin/admin-ajax.php?action=edit_user_email',
                        data: {
                            user_id: userId,
                            new_email: email
                        },
                        beforeSend: function () {
                            showLoadingScreen();
                        },
                        complete: function () {
                            setTimeout(function(){
                                hideLoadingScreen()
                            }, 1000);
                        },
                        success: function(response) {
                            btn.siblings('input').prop('disabled', true)
                            btn.text('Edit')
                            alert('Email updated successfully!')
                        },
                        error: function(xhr, status, error) {
                            console.error('Error updating email:', error)
                        }
                    })
                } else {
                    alert('Type a valid email.')
                    btn.siblings('input').focus().css('border', '1px solid #fd604c')
                }
            } else {
                let password = btn.siblings('input').val()

                $.ajax({
                    type: 'POST',
                    url: '/wp-admin/admin-ajax.php?action=edit_user_password',
                    data: {
                        user_id: userId,
                        new_password: password
                    },
                    beforeSend: function () {
                        showLoadingScreen();
                    },
                    complete: function () {
                        setTimeout(function(){
                            hideLoadingScreen()
                        }, 1000);
                    },
                    success: function(response) {
                        btn.siblings('input').prop('disabled', true)
                        btn.text('Edit')
                        alert('Password updated successfully!')
                    },
                    error: function(xhr, status, error) {
                        btn.siblings('input').focus().css('border', '1px solid #fd604c')
                    }
                });
            }
        }

    })
}

function ticket() {
    const apiToken = 'pk_48787545_XGXTPIF1JZI88F2O3CDUZDMIQ1FGS5GO'
    const listId = '901304034991'

    createTicket()
    
    $('body').on('click', '.card__body-task', function() {
        openTicket($(this), apiToken)
    })

    $('[data-menu="track-open-tickets"], [data-menu="closed-tickets"]').on('click', function() {
        loadTickets($(this).data('menu'), apiToken, listId)
    })

    $('body').on('click', '.card--ticket-open', function() {
        $('.content').removeClass('content--active')
        $('.content[data-content=track-open-tickets]').addClass('content--active')
        $('.aside__item-submenu span.aside__item--active').removeClass('aside__item--active')
        $('.aside__item-submenu span[data-menu=track-open-tickets]').addClass('aside__item--active')
    })

    $('body').on('click', '.card--ticket-closed', function() {
        $('.content').removeClass('content--active')
        $('.content[data-content=closed-tickets]').addClass('content--active')
        $('.aside__item-submenu span.aside__item--active').removeClass('aside__item--active')
        $('.aside__item-submenu span[data-menu=closed-tickets]').addClass('aside__item--active')
    })
    
    $('body').on('click', '.card--ticket-request', function() {
        $('.content').removeClass('content--active')
        $('.content[data-content=request-new-ticket]').addClass('content--active')
        $('.aside__item-submenu span.aside__item--active').removeClass('aside__item--active')
        $('.aside__item-submenu span[data-menu=request-new-ticket]').addClass('aside__item--active')
    })
}

function createTicket() {
    $('.card--ticket__categories').on('change', function() {
        $('.card--ticket__categories').css('border', 'none')
    })

    $('.card--ticket__content, .card--ticket__title').on('keypress', function() {
        if($(this).val() !== '') {
            $(this).css('border', 'none')
        }
    })

    $('.card--ticket__send').on('click', function() {
        let categorie = $('select.card--ticket__categories')
        let title = $('.card--ticket__title')
        let content = $('.card--ticket__content')
        let postId = null
        var bodyClasses = $('body').attr('class').split(' ')

        $.each(bodyClasses, function(index, className) {
            if (className.startsWith('postid-')) {
                postId = className.replace('postid-', '')
                return false 
            }
        })

        if(categorie.val() === '') {
            categorie.focus().css('border', '1px solid #fd604c')
            alert('Select a category.')
            return;
        }

        if(title.val() == '') {
            title.focus().css('border', '1px solid #fd604c')
            alert('Title field empty.')
            return;
        }

        if(content.val() == '') {
            content.focus().css('border', '1px solid #fd604c')
            alert('Message field empty.')
            return;
        }

        $.ajax({
            type: 'POST',
            url: '/wp-admin/admin-ajax.php?action=create_new_ticket',
            data: {
                ticket_title: title.val(),
                ticket_content: content.val(),
                ticket_category: categorie.val(),
                post_id: postId
            },
            beforeSend: function () {
                showLoadingScreen();
            },
            complete: function () {
                setTimeout(function(){
                    hideLoadingScreen()
                }, 1000);
            },
            success: function(response) {
                title.val('')
                content.val('')

                alert('Ticket created!');
            },
            error: function(error) {
                alert('An error occurred. Please try again.');

            }
        })
    })
}

function loadTickets(type, apiToken, listId) {
    const tagsToFilter = $('body').data('hotel-code').toLowerCase()

    const listUrl = `https://api.clickup.com/api/v2/list/${listId}/task`

    const headers = {
        'Authorization': apiToken,
        'Content-Type': 'application/json'
    }

    const params = $.param({
        'tags[]': [tagsToFilter],
        'include_closed': 'true'
    })

    $.ajax({
        url: listUrl+'?'+params,
        method: 'GET',
        headers: headers,
        beforeSend: function () {
            showLoadingScreen();
            $('[data-content="track-open-tickets"]').removeClass('content--active')
            $('[data-content="closed-tickets"]').removeClass('content--active')
        },
        complete: function () {
            setTimeout(function(){
                hideLoadingScreen()
            }, 1000)
        },
        success: function(response) {
            const tasks = response.tasks

            if (tasks && tasks.length > 0) {
                let openTasks = 0, doneTasks = 0
                let openTasksHtml = '', closedTasksHtml = ''
                let openTasksCategories = [], closedTasksCategories = []

                tasks.forEach(task => {
                    let date = unixConversion(task.date_created);
                    let categorie = ''

                    $.each(task.tags, function(i, value) {
                        if(value.name != tagsToFilter) {
                            categorie = value.name
                        }
                    })

                    if(task.status.type != 'closed') {

                        openTasks++
                        openTasksHtml +=
                        `<div class="card__body-task" data-ticket-id="${task.id}">
                            <span>${task.name}</span>
                            <span>${categorie}</span>
                            <span>${date}</span>
                            <span style="color: ${task.status.color}">${task.status.status}</span>
                            <button>Open Ticket</button>
                        </div>`

                        if(!openTasksCategories.includes(categorie)) {
                            openTasksCategories.push(categorie)
                        }
                    }

                    if(task.status.type == 'closed') {
                        doneTasks++
                        closedTasksHtml +=
                        `<div class="card__body-task" data-ticket-id="${task.id}">
                            <span>${task.name}</span>
                            <span>${categorie}</span>
                            <span>${date}</span>
                            <span style="color: ${task.status.color}">${task.status.status}</span>
                            <button>Open Ticket</button>
                        </div>`

                        if(!closedTasksCategories.includes(categorie)) {
                            closedTasksCategories.push(categorie)
                        }
                    }
                })

                $('.card__body-content').empty()

                $('.card--tickets__open .card__header h4').text('Open Tickets (' + openTasks + ')')
                $('.card--tickets__closed .card__header h4').text('Closed Tickets (' + doneTasks + ')')

                $('.card--ticket-open').each(function() {
                    $(this).find('.card--ticket__text span').last().text(openTasks)
                })

                $('.card--ticket-closed').each(function() {
                    $(this).find('.card--ticket__text span').last().text(doneTasks)
                })

                $('.card--tickets__open .card__body .card__body-content').append(openTasksHtml)
                $('.card--tickets__closed .card__body .card__body-content').append(closedTasksHtml)

                if($('.card--tickets__open .card__header .nice-select').length == 0 && $('.card--tickets__open .card__header select').length > 0) {
                    $.each(openTasksCategories, function(i, categ){
                        $('.card--tickets__open .card__header select').append('<option value="'+categ+'">'+categ+'</option>')
                    })
                    
                    NiceSelect.bind(document.querySelector('.card--tickets__open .card__header select'))
                }

                if($('.card--tickets__closed .card__header .nice-select').length == 0 && $('.card--tickets__closed .card__header select').length > 0) {
                    $.each(closedTasksCategories, function(i, categ){
                        $('.card--tickets__closed .card__header select').append('<option value="'+categ+'">'+categ+'</option>')
                    })

                    NiceSelect.bind(document.querySelector('.card--tickets__closed .card__header select'))
                }
            } else {
                $('[data-content="track-open-tickets"] h2, [data-content="closed-tickets"] h2').text('SUPPORT CENTER - No tasks found')

                $('[data-content="track-open-tickets"], [data-content="closed-tickets"]').find('.card').remove()
            }

            if(type == 'track-open-tickets') {
                $('[data-content="track-open-tickets"]').addClass('content--active')
            } else {
                $('[data-content="closed-tickets"]').addClass('content--active')
            }

            ticketFilter()
        },
        error: function(xhr, status, error) {
            console.error('Failed to retrieve tasks:', status, error)
            $('#tasks').html('<p>Failed to retrieve tasks. Check the console for details.</p>')
        }
    })
}

function ticketFilter() {
    $('.card--tickets .card__header select').on('change', function() {
        let taskCategorie = $(this).val()
        let tasksContainer = $(this).closest('.card').find('.card__body-content .card__body-task')

        tasksContainer.each(function(){
            if(taskCategorie == '' || $(this).text().includes(taskCategorie)) {
                $(this).show()
            } else {
                $(this).hide()
            }
        })
    })

    $('.card--tickets .card__header input[type=search]').on('input', function() {
        let taskValue = $(this).val()
        let tasksContainer = $(this).closest('.card').find('.card__body-content .card__body-task')

        tasksContainer.each(function(){
            if(taskValue == '' || $(this).find('span:first-of-type').text().includes(taskValue)) {
                $(this).show()
            } else {
                $(this).hide()
            }
        })
    })
}

function openTicket(btn, apiToken) {
    let taskId = btn.closest('.card__body-task').data('ticket-id')
    const listUrl = `https://api.clickup.com/api/v2/task/${taskId}/`

    const headers = {
        'Authorization': apiToken,
        'Content-Type': 'application/json'
    }

    $.ajax({
        url: listUrl,
        method: 'GET',
        headers: headers,
        beforeSend: function () {
            showLoadingScreen();
            $('[data-content="track-open-tickets"]').removeClass('content--active')
            $('[data-content="closed-tickets"]').removeClass('content--active')
            $('[data-content="ticket"] .card article').empty()
        },
        complete: function () {
            $('[data-content="ticket"]').addClass('content--active')
            setTimeout(function(){
                hideLoadingScreen()
            }, 1000)
        },
        success: function(response) {
            let container = $('[data-content="ticket"] .card')
            let task = response
            let title = task.name
            let description = task.description
            let status = task.status.status
            let statusColor = task.status.color
            let date = task.date_updated

            console.log(task);

            container.find('h3').text(title)
            container.find('.card__body article').append(description)
            container.find('.card__body article').append('<span>'+unixConversion(date)+'<strong style="color: '+statusColor+'">'+status+'</strong></span>')
        },
        error: function(xhr, status, error) {
            alert('Task not found')
        }
    })
}

function unixConversion(unix) {
    let date = new Date(0)
    date = new Date(new Number(unix))
    let year = date.getFullYear()
    let month = ('0' + (date.getMonth() + 1)).slice(-2)
    let day = ('0' + date.getDate()).slice(-2)
    let hours = ('0' + date.getHours()).slice(-2)
    let minutes = ('0' + date.getMinutes()).slice(-2)
    let seconds = ('0' + date.getSeconds()).slice(-2)

    date = year + ' | ' + month + ' | ' + day + ' - ' + hours + ':' + minutes + ':' + seconds

    return date
}

function hideMenus() {
    if($('body').data('role') == 'contributor') {
        $('.table__foot-addrow, .deleteRowBtn, .remove-file, .upload-file, .remove-images, .upload-file, form:has(.upload-file), .table__row-controls-delete, .table__body:has(.table__row .table__row-form)').remove()

        $('.table__body').each(function() {
            if($.trim($(this).html()) === '') {
                $(this).closest('.card').remove()
            }
        })

        $('.table__foot-submit').each(function() {
            if($(this).text() == 'Submit File') {
                $(this).remove()
            }
        })

        $('.table').each(function() {
            if($(this).find('.table__body').length == 0) {
                $(this).closest('.card').remove()
            }
        })

        $('.content').each(function() {
            if($(this).find('h2').siblings().length == 0) {
                let content = $(this).data('content')

                $('[data-content="'+content+'"]:not([data-content="home"]), [data-menu="'+content+'"]:not([data-menu="home"])').remove()
            }
        })

        $('.aside__menu .aside__item-submenu').each(function() {
            if($(this).children().length == 0) {
                $(this).closest('.aside__menu').remove()
            }
        })

        $('.aside__item-submenu-sub').each(function() {
            if($(this).children().length == 0) {
                $(this).prev('.aside__item-head').remove()
                $(this).remove()
            }
        })
    }
}

function select() {
    NiceSelect.bind(document.getElementById('ticket-categories'))
}

function scrollbar() {
    $('[data-simplebar]').each(function() {
        if($(this).find('.simplebar-content').html().length > 0) {
            new SimpleBar($(this)[0])
        }
    })
}