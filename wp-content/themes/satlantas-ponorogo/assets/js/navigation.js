( function () {
	const button = document.querySelector( '.menu-toggle' );
	const menu = document.querySelector( '.main-navigation .menu' );

	if ( ! button || ! menu ) {
		return;
	}

	button.addEventListener( 'click', function () {
		const expanded = button.getAttribute( 'aria-expanded' ) === 'true';
		button.setAttribute( 'aria-expanded', String( ! expanded ) );
		menu.classList.toggle( 'is-open' );
	} );
}() );
