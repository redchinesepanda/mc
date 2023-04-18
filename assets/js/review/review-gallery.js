// Open the Modal
// function openModal() {
// 	document.getElementById( "myModal" ).style.display = "block";
// }

// Close the Modal
// function closeModal() {
// 	document.getElementById( "myModal" ).style.display = "none";
// }

// var slideIndex = 1;
// showSlides( slideIndex );

// Next/previous controls
// function plusSlides( n ) {
// 	showSlides(slideIndex += n);
// }

// Thumbnail image controls
// function currentSlide( n ) {
// 	showSlides( slideIndex = n );
// }

// function showSlides( n ) {
// 	var i;

// 	var slides = document.getElementsByClassName("mySlides");

// 	var dots = document.getElementsByClassName("demo");

// 	var captionText = document.getElementById("caption");

// 	if (n > slides.length) {slideIndex = 1}

// 	if (n < 1) {slideIndex = slides.length}

// 	for (i = 0; i < slides.length; i++) {
// 		slides[i].style.display = "none";
// 	}

// 	for (i = 0; i < dots.length; i++) {
// 		dots[i].className = dots[i].className.replace(" active", "");
// 	}

// 	slides[slideIndex-1].style.display = "block";

// 	dots[slideIndex-1].className += " active";

// 	captionText.innerHTML = dots[slideIndex-1].alt;
// }

// review-gallery start

document.addEventListener( 'DOMContentLoaded', function ()
{
    // function tabToggle( event )
    // {
    //     let tabs = document.getElementById( event.currentTarget.dataset.tabs );

    //     tabs.querySelectorAll( '.legal-tab-title' ).forEach( ( title ) => {
    //         title.classList.remove( 'legal-active' );
    //     });

    //     tabs.querySelectorAll( '.legal-tab-content' ).forEach( ( content ) => {
    //         content.classList.remove( 'legal-active' );
    //     });
        
    //     event.currentTarget.classList.add( 'legal-active' );

    //     tabs.querySelector( '.legal-content-' + event.currentTarget.dataset.content ).classList.add( 'legal-active' );
    // }

    // Array.from( document.getElementsByClassName( 'legal-tabs' ) ).forEach( function callback( tabs, index ) {
    //     tabs.id = "legal-tabs-" + index;

    //     let titles = tabs.getElementsByClassName( 'legal-tab-title' );

    //     for ( let title of titles ) {
    //         title.dataset.tabs = tabs.id;

    //         title.addEventListener( 'click', tabToggle, false );
    //     }
    // });

	document.querySelectorAll( '.tcb-post-content > .gallery' ).forEach( function ( gallery ) {
		console.log( 'review-gallery gallery: ' + gallery.id );

		gallery.childNodes.forEach( function ( figure ) {
			console.log( 'review-gallery figure: ' + figure );
		} );
	} );

} );

// review-gallery-js end