/**
 * CTA Block — script.js
 *
 * Lazy-loads background video via IntersectionObserver.
 * Sets the <video> src from data-src when the block enters the viewport,
 * then fades out the poster image once the video starts playing.
 */
( function () {
	'use strict';

	/** @param {HTMLElement} section */
	function initVideoBlock( section ) {
		const video = section.querySelector( '.cta__bg-video' );
		if ( ! video || ! video.dataset.src ) {
			return;
		}

		// Skip on small screens (poster shown instead).
		if ( window.matchMedia( '(max-width: 47.999rem)' ).matches ) {
			return;
		}

		const observer = new IntersectionObserver(
			( entries ) => {
				entries.forEach( ( entry ) => {
					if ( ! entry.isIntersecting ) {
						return;
					}
					observer.unobserve( section );

					// Load video source.
					const source = document.createElement( 'source' );
					source.src  = video.dataset.src;
					source.type = video.dataset.src.endsWith( '.webm' )
						? 'video/webm'
						: 'video/mp4';
					video.appendChild( source );
					video.load();

					video.addEventListener( 'playing', function () {
						section.classList.add( 'cta--video-playing' );
					}, { once: true } );
				} );
			},
			{ rootMargin: '200px 0px' }
		);

		observer.observe( section );
	}

	// Init all CTA video blocks on the page.
	document.querySelectorAll( '.cta--video' ).forEach( initVideoBlock );
} )();
