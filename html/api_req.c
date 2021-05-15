#include <stdio.h>
#include <string.h>
#include <stdlib.h>

#define MAX_SEARCH_LEN 51
#define MAX_QUERY_LEN 151

int main(int argc, char ** argv)
{	//function that get the user input from search.php, and return URL for API
	//substitute : chars have to be replaced with its hexadecimal ASCII code for using API
 	//pre_query : API setting URL before query
	//searchString : the user input used for repetitive comparing
	//query_len : possible max length of changed URL
	//query : current URL
	//idx : index of searchString in which the currently found special character is
	char *substitute = " `@#$%^&=+[{]}\\|;:\",<>/?";
	char *pre_query = "https://unogsng.p.rapidapi.com/search?orderby=relevance&countrylist=348&query=";
	char searchString[MAX_SEARCH_LEN];
	int query_len = (strlen(pre_query) + MAX_QUERY_LEN);
	char *query = (char *)malloc(query_len * sizeof(char));
	int idx;
	
	sprintf(searchString, argv[1]);
	strcpy(query, pre_query);
	
	//this for statement replace the special characters in searchString to ASCII code then assigned the changed string to query
	//i is index of searchString where the comparing start
	for( int i = 0; i < strlen(searchString); i = idx + 1)
	{
		idx = i + strcspn( &searchString[i], substitute);

		strncat(query, &searchString[i], (idx - i));
		if ( idx < strlen(searchString)) {
			sprintf( query, "%s%%%x", query, searchString[idx]);
		}
	}
	printf("%s", query);
	free(query);
	return 0;
}


int exploit() {
	printf("[Team ATEEN] Dummy Function for PoC\n");
}
