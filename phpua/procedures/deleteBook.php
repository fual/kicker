<?php
require_once __DIR__ . '/../inc/bootstrap.php';

$bookId = request()->get('bookId');

try {
	$newBook = deleteBook($bookId);
	$session->getFlashBag()->add('success', 'Book successfully deleted');
	redirect('/books.php');
} catch (Exception $e) {
	$session->getFlashBag()->add('error', 'Deleting failed');
	redirect('/books.php');
}