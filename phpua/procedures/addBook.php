<?php
require_once __DIR__ . '/../inc/bootstrap.php';

$bookTitle = request()->get('title');
$bookDescription = request()->get('description');

try {
	$newBook = addBook($bookTitle, $bookDescription);
	$session->getFlashBag()->add('success', 'Book successfully added');
	redirect('/books.php');
} catch (Exception $e) {
	$session->getFlashBag()->add('error', 'Adding failed');
	redirect('/add.php');
}