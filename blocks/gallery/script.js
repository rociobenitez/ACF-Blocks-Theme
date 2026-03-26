/**
 * Gallery Block — Lightbox
 *
 * Lightweight, accessible lightbox with keyboard navigation and touch swipe.
 * No external dependencies. Follows WordPress best practices for frontend JS.
 */
( function () {
	'use strict';

	// Only run on frontend (not in block editor).
	if ( document.body.classList.contains( 'wp-admin' ) || document.querySelector( '.block-editor-page' ) ) {
		return;
	}

	const GALLERIES = document.querySelectorAll( '.gallery--has-lightbox' );

	if ( ! GALLERIES.length ) {
		return;
	}

	// ── Lightbox DOM (created once, shared across galleries) ──

	let lightbox = null;
	let imgEl = null;
	let captionEl = null;
	let counterEl = null;
	let currentItems = [];
	let currentIndex = 0;
	let touchStartX = 0;
	let touchStartY = 0;
	let lastFocused = null;

	function createLightbox() {
		lightbox = document.createElement( 'div' );
		lightbox.className = 'gallery-lightbox';
		lightbox.setAttribute( 'role', 'dialog' );
		lightbox.setAttribute( 'aria-modal', 'true' );
		lightbox.setAttribute( 'aria-label', 'Galería de imágenes ampliada' );
		lightbox.setAttribute( 'aria-hidden', 'true' );

		lightbox.innerHTML = `
			<div class="gallery-lightbox__inner">
				<img class="gallery-lightbox__img" src="" alt="" />
				<span class="gallery-lightbox__counter" aria-live="polite"></span>
				<p class="gallery-lightbox__caption"></p>
				<button class="gallery-lightbox__close" type="button" aria-label="Cerrar galería">
					<svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>
				</button>
				<button class="gallery-lightbox__prev" type="button" aria-label="Imagen anterior">
					<svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="15 18 9 12 15 6"/></svg>
				</button>
				<button class="gallery-lightbox__next" type="button" aria-label="Imagen siguiente">
					<svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="9 6 15 12 9 18"/></svg>
				</button>
			</div>
		`;

		document.body.appendChild( lightbox );

		imgEl = lightbox.querySelector( '.gallery-lightbox__img' );
		captionEl = lightbox.querySelector( '.gallery-lightbox__caption' );
		counterEl = lightbox.querySelector( '.gallery-lightbox__counter' );

		// Event listeners.
		lightbox.querySelector( '.gallery-lightbox__close' ).addEventListener( 'click', close );
		lightbox.querySelector( '.gallery-lightbox__prev' ).addEventListener( 'click', prev );
		lightbox.querySelector( '.gallery-lightbox__next' ).addEventListener( 'click', next );

		// Close on backdrop click (not on image/buttons).
		lightbox.querySelector( '.gallery-lightbox__inner' ).addEventListener( 'click', function ( e ) {
			if ( e.target === this ) {
				close();
			}
		} );

		// Keyboard.
		document.addEventListener( 'keydown', onKeyDown );

		// Touch swipe.
		lightbox.addEventListener( 'touchstart', onTouchStart, { passive: true } );
		lightbox.addEventListener( 'touchend', onTouchEnd, { passive: true } );
	}

	// ── Navigation ──

	function showImage( index ) {
		if ( ! currentItems.length ) {
			return;
		}

		currentIndex = ( index + currentItems.length ) % currentItems.length;
		const item = currentItems[ currentIndex ];

		imgEl.src = item.src;
		imgEl.alt = item.alt;

		if ( item.caption ) {
			captionEl.textContent = item.caption;
			captionEl.style.display = '';
		} else {
			captionEl.textContent = '';
			captionEl.style.display = 'none';
		}

		counterEl.textContent = ( currentIndex + 1 ) + ' / ' + currentItems.length;

		// Preload adjacent images.
		preload( ( currentIndex + 1 ) % currentItems.length );
		preload( ( currentIndex - 1 + currentItems.length ) % currentItems.length );
	}

	function preload( index ) {
		if ( currentItems[ index ] ) {
			const img = new Image();
			img.src = currentItems[ index ].src;
		}
	}

	function prev() {
		showImage( currentIndex - 1 );
	}

	function next() {
		showImage( currentIndex + 1 );
	}

	// ── Open / Close ──

	function open( galleryEl, index ) {
		if ( ! lightbox ) {
			createLightbox();
		}

		// Collect items from this specific gallery.
		const links = galleryEl.querySelectorAll( '.gallery__link' );
		currentItems = Array.from( links ).map( function ( link ) {
			return {
				src: link.getAttribute( 'href' ),
				alt: ( link.querySelector( 'img' ) || {} ).alt || '',
				caption: link.getAttribute( 'data-gallery-caption' ) || '',
			};
		} );

		// Toggle single-image class.
		lightbox.classList.toggle( 'gallery-lightbox--single', currentItems.length <= 1 );

		// Save focus for restoration.
		lastFocused = document.activeElement;

		// Prevent body scroll.
		document.documentElement.style.overflow = 'hidden';

		lightbox.setAttribute( 'aria-hidden', 'false' );
		showImage( index );

		// Focus close button for accessibility.
		requestAnimationFrame( function () {
			lightbox.querySelector( '.gallery-lightbox__close' ).focus();
		} );
	}

	function close() {
		if ( ! lightbox ) {
			return;
		}

		lightbox.setAttribute( 'aria-hidden', 'true' );
		document.documentElement.style.overflow = '';
		currentItems = [];

		// Restore focus.
		if ( lastFocused ) {
			lastFocused.focus();
			lastFocused = null;
		}
	}

	// ── Keyboard ──

	function onKeyDown( e ) {
		if ( lightbox.getAttribute( 'aria-hidden' ) === 'true' ) {
			return;
		}

		switch ( e.key ) {
			case 'Escape':
				close();
				break;
			case 'ArrowLeft':
				prev();
				break;
			case 'ArrowRight':
				next();
				break;
			case 'Tab':
				trapFocus( e );
				break;
		}
	}

	function trapFocus( e ) {
		const focusable = lightbox.querySelectorAll( 'button:not([disabled])' );
		if ( ! focusable.length ) {
			return;
		}

		const first = focusable[ 0 ];
		const last = focusable[ focusable.length - 1 ];

		if ( e.shiftKey && document.activeElement === first ) {
			e.preventDefault();
			last.focus();
		} else if ( ! e.shiftKey && document.activeElement === last ) {
			e.preventDefault();
			first.focus();
		}
	}

	// ── Touch ──

	function onTouchStart( e ) {
		touchStartX = e.changedTouches[ 0 ].screenX;
		touchStartY = e.changedTouches[ 0 ].screenY;
	}

	function onTouchEnd( e ) {
		const dx = e.changedTouches[ 0 ].screenX - touchStartX;
		const dy = e.changedTouches[ 0 ].screenY - touchStartY;

		// Only swipe if horizontal movement is dominant and > 50px.
		if ( Math.abs( dx ) > 50 && Math.abs( dx ) > Math.abs( dy ) * 1.5 ) {
			if ( dx > 0 ) {
				prev();
			} else {
				next();
			}
		}
	}

	// ── Init: bind click handlers ──

	GALLERIES.forEach( function ( gallery ) {
		gallery.addEventListener( 'click', function ( e ) {
			const link = e.target.closest( '.gallery__link' );
			if ( ! link ) {
				return;
			}

			e.preventDefault();
			var index = parseInt( link.getAttribute( 'data-gallery-index' ), 10 ) || 0;
			open( gallery, index );
		} );
	} );
} )();
