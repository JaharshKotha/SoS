To use our security library:
1) Both the library and the developer should be preferably in the same directory
2) include("injprev.php"); in the developer code
3) Then according to the developer's choice, he can either call 
	a) sanitize_input function by passing the connection details as an array of localhost,username,password,database name, user input and data type as string
	b)pwi() function by passing the connection details as an array with details of localhost,database name, user name,password.
4) The sanitized input returned could be passed to the query for its execution

