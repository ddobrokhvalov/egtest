# Egamings test task

### Requirements

- PHP 7.2+
- MySQL 5.7+

### Testing

Local run: `php -S localhost:8000` 

### Tasks

You have database, with one table `testdata`, holding transactions info (~10 mil rows).
You have main page (index.php) with transactions count and list, and reports pages. 
Complete as much tasks as you can. 
Database schema modifications allowed.
Database engine changes not allowed (use only InnoDB).

You can flush database to initial state using `flush_db.php` script.

1. Fix error `Call to private method Transactions::getList()` on index page.
2. Fix notice `Undefined index: amount` on summary page.
3. Implement form for adding new transactions.
4. For task 3, add data check: only correct types, only numeric amounts.
5. Index page took >3 sec. to load. Try to speed it up (<1 sec. will be great) 
without loosing functionality.
6. Top page takes >5 sec. to load. Speed it up.
7. Add paging support on index page. Something like 1-2 ... 6-7-8 ... 1000-1001, when we looking at page 7.
8. Summary page took >15 sec. to load. Try to find a way to speed it up.
