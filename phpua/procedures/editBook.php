<?php
require_once __DIR__ . '/../inc/bootstrap.php';

$bookId = request()->get('bookId');
$bookTitle = request()->get('title');
$bookDescription = request()->get('description');

try {
	$newBook = updateBook($bookId, $bookTitle, $bookDescription);
	$session->getFlashBag()->add('success', 'Book successfully edited');
	redirect('/books.php');
} catch (Exception $e) {
	$session->getFlashBag()->add('error', 'Editing failed');
	redirect('/edit.php?bookId='.$bookId);
}