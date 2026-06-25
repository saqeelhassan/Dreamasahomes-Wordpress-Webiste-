<?php
/**
 * Legacy endpoint intentionally disabled for security.
 *
 * Use Contact Form 7 shortcode in the Contact page instead.
 */

http_response_code( 403 );
header( 'Content-Type: text/plain; charset=UTF-8' );
exit( 'Direct access disabled.' );
