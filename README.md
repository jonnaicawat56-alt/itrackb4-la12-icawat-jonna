LABORATORY ACTIVITY 13
Open the Front 

J1.Your HomeController is not a resource controller. Name two things an index() on a resource controller does that yours does not have to?
A resource controller has more methods like create(), store(), show(), edit(), update(), and destroy(). These methods handle creating, saving, viewing, editing, and deleting records. My HomeController only displays the home page, so it does not need all these methods.

J2.Your pagination links lost the search term until you added one method. Say what those links contained before, and what the controller therefore received?
Before adding withQueryString(), the pagination links only contained the page number and did not include the search term or filters. Because of this, the controller received an empty search value when I clicked page 2. Adding withQueryString() keeps the search and filter values in the pagination links.

J3.A misspelled sort value does not break your page. Explain why that is worse than an error, and what your allowed list does about it?
It is worse because the page still works, but it may show results in an unexpected order without telling the user that the sort value is invalid. The allowed list checks if the requested column is valid, and if not, it automatically uses name as the default sorting column.